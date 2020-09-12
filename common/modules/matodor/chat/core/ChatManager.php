<?php

namespace matodor\chat\core;

use Yii;
use matodor\chat\ChatModule;
use matodor\chat\core\WsChatRoom;
use matodor\chat\core\BaseChatComponent;
use matodor\chat\events\BeforeCreateRoom;
use matodor\chat\events\BeforeDeleteEmptyRoom;
use matodor\chat\events\BeforeRoomConnect;
use matodor\chat\events\BeforeRequireRooms;
use matodor\chat\events\RoomConnected;
use matodor\chat\events\RoomCreated;
use matodor\chat\events\RoomDisconnected;
use matodor\chat\models\ChatAttachment;
use matodor\chat\models\ChatAttachmentToMessage;
use matodor\chat\models\ChatRoom;
use matodor\chat\models\ChatRoomMessage;
use matodor\chat\models\ChatRoomUser;
use matodor\chat\models\ChatUser;
use matodor\chat\models\ChatUserProfile;
use matodor\chat\models\forms\CreateDialog;
use matodor\chat\models\forms\SetInfo;

class ChatManager extends BaseChatComponent
{
    const BeforeRequireRoomsEvent = 'BeforeRequireRoomsEvent';
    const BeforeRoomConnectEvent = 'BeforeRoomConnectEvent';
    const BeforeDeleteEmptyRoomEvent = 'BeforeDeleteEmptyRoomEvent';
    const BeforeCreateRoomEvent = 'BeforeCreateRoomEvent';
    const RoomConnectedEvent = 'RoomConnectedEvent';
    const RoomDisconnectedEvent = 'RoomDisconnectedEvent';
    const RoomDeletedEvent = 'RoomDeletedEvent';
    const RoomCreatedEvent = 'RoomCreatedEvent';

    public static function can(ChatRoomUser $roomUser, int $right)
    {
        return ($roomUser->rights & $right) != 0;
    }

    public function deleteEmptyRooms()
    {
        /** @var ChatRoom[] $emptyRooms */
        $emptyRooms = ChatRoom::find()
            ->leftJoin('chat_room_message', 'chat_room_message.room_id = chat_room.id')
            ->andWhere(['chat_room_message.id' => null])
            ->andWhere('TIME_TO_SEC(TIMEDIFF(NOW(), FROM_UNIXTIME(chat_room.create_time))) > 86400') // 24 hours
            ->all();

        foreach ($emptyRooms as $emptyRoom)
        {
            $event = new BeforeDeleteEmptyRoom();
            $event->worker = $this->worker;
            $event->chatRoom = $emptyRoom;
            $this->trigger(self::BeforeDeleteEmptyRoomEvent, $event);

            if ($event->abort)
                continue;

            $this->deleteRoom($emptyRoom);
        }
    }

    protected function deleteMessage(ChatRoomMessage $message)
    {
        $chatRoom = $message->chatRoom;
        $this->worker->log('ChatManager', "Delete message {$message->id}");
        $this->worker->broadcast($chatRoom->users, ChatCommands::SERVER_CHAT_DELETE_MESSAGE,
            ['roomId' => $chatRoom->id, 'messageId' => $message->id]);

        $message->delete();
    }

    protected function deleteRoom(ChatRoom $chatRoom)
    {
        $users = $chatRoom->users;
        foreach ($users as $user)
        {
            $sessions = $this->worker->sessionManager->getSessions($user->chat_user_id);
            foreach ($sessions as $session)
            {
                if ($session->connectedChat === null ||
                    $session->connectedChat->id != $chatRoom->id)
                {
                    continue;
                }

                $session->connectedChat = null;
            }
        }

        $this->worker->log('ChatManager', "Delete room {$chatRoom->id}");
        $this->worker->broadcast($chatRoom->users, ChatCommands::SERVER_CHAT_DELETE,
            ['roomId' => $chatRoom->id]);

        $chatRoom->delete();
    }

    /**
     * Обрабокта запроса получения списка диалогов для пользователя
     * @param ChatSession $session
     * @param int|null $userId
     * @return boolean
     */
    public function onGetChatList(ChatSession $session, $payload)
    {
        $event = new BeforeRequireRooms();
        $event->worker = $this->worker;
        $event->query = $session->getChatUser()->getRooms();
        $this->trigger(self::BeforeRequireRoomsEvent, $event);

        if ($event->abort)
            return false;

        $rooms = $session->getChatUser()->getRoomsWithData($event->query);
        $session->sendCommand(ChatCommands::SERVER_CHAT_LIST, ['chats' => $rooms]);

        return true;
    }

    public function onClientCreateChat(ChatSession $session, $payload)
    {
        if (!$this->hasEventHandlers(self::RoomCreatedEvent))
        {
            $this->worker->log('ChatManager', 'Setup RoomCreatedEvent');
            $session->sendCommand(ChatCommands::SERVER_CHAT_CREATE_ERROR, [
                'error' => $session->t('matodor.chat', 'chat.server_error')]);
            return false;
        }

        $model = new CreateDialog();
        $model->load($payload);

        if (!$model->validate())
        {
            $session->sendCommand(ChatCommands::SERVER_CHAT_CREATE_ERROR, [
                'error' => $model->getErrors()]);
            return false;
        }

        $chatRoom = new ChatRoom();
        $chatRoom->title = $model->question;
        $chatRoom->token = ChatModule::getRandomId(32);

        $beforeEvent = new BeforeCreateRoom();
        $beforeEvent->worker = $this->worker;
        $beforeEvent->chatRoom = $chatRoom;
        $beforeEvent->session = $session;
        $beforeEvent->abortReason = $session->t('matodor.chat', 'chat.bad_request');
        $this->trigger(self::BeforeCreateRoomEvent, $beforeEvent);

        if ($beforeEvent->abort)
        {
            $session->sendCommand(ChatCommands::SERVER_CHAT_CREATE_ERROR, [
                'error' => $beforeEvent->abortReason]);
            return false;
        }

        if (!$chatRoom->save())
        {
            $session->sendCommand(ChatCommands::SERVER_CHAT_CREATE_ERROR,
                $chatRoom->getErrors());
            return;
        }

        $afterEvent = new RoomCreated();
        $afterEvent->worker = $this->worker;
        $afterEvent->chatRoom = $chatRoom;
        $afterEvent->session = $session;
        $this->trigger(self::RoomCreatedEvent, $afterEvent);

        $roomData = $chatRoom->toArray();
        ChatUser::setRoomData($roomData);

        $session->sendCommand(ChatCommands::SERVER_CHAT_CREATE_SUCCESS, $roomData);
        $this->worker->broadcast($chatRoom->users, ChatCommands::SERVER_CHAT_LIST,[
            'chats' => [$roomData],
        ]);
    }

    /**
     * Обработка запроса заполнения данных профиля пользователя в первый раз
     *
     * @param ChatSession $session
     * @param array $payload
     * @return boolean
     */
    public function onClientSetInfo(ChatSession $session, $payload)
    {
        /** @var matodor\chat\models\ChatUserProfile $profile */
        $profile = $session->getChatUser()->getProfile()->one();

        if (!is_null($profile))
        {
            $session->sendCommand(ChatCommands::SERVER_SET_INFO_ERROR, [
                'error' => $session->t('matodor.chat', 'chat.profile_already_created')]);
            return false;
        }

        $model = new SetInfo();

        if (!$model->load($payload) ||
            !$model->validate())
        {
            $session->sendCommand(ChatCommands::SERVER_SET_INFO_ERROR, [
                'error' => $model->getErrors()]);
            return false;
        }

        $profile = new ChatUserProfile();
        $profile->chat_user_id = $session->getChatUser()->id;
        $profile->email = $model->email;
        $profile->name = $model->lastName . ' ' . $model->firstName;

        if ($profile->save())
        {
            $session->sendCommand(ChatCommands::SERVER_SET_INFO_SUCCESS, $profile->toArray());
            $session->sendCommand(ChatCommands::SERVER_SUCCESS_AUTH, [
                'chatUserId' => $session->getChatUser()->id,
                'isGuest' => $session->isGuest(),
                'profile' => $profile->toArray(),
            ]);
            return true;
        }
        else
        {
            $session->sendCommand(ChatCommands::SERVER_SET_INFO_ERROR,
                $profile->getErrors());
            return false;
        }
    }

    /**
     * Обработка запроса на отправку сообщений с вложенным файлом
     * @param ChatSession $session
     * @param array $payload ['attachments', 'roomId]
     * @return boolean
     */
    public function onClientSendAttachment(ChatSession $session, $payload)
    {
        $payload['text'] = $session->t('matodor.chat', 'chat.attachment_message_header');

        if (!is_array($payload['attachments']))
        {
            $session->sendCommand(ChatCommands::SERVER_CHAT_ATTACHMENT_ERROR, [
                'error' => $session->t('matodor.chat', 'chat.attachment_bad_request')]);
            return false;
        }

        $this->onChatMessage($session, $payload);
    }

    /**
     * Обработка запроса на удаление сообщения в диалоге
     * @param ChatSession $session
     * @param array $payload ['messageId']
     * @return boolean
     */
    public function onChatDeleteMessage(ChatSession $session, $payload)
    {
        $message = ChatRoomMessage::findOne(['id' => $payload['messageId']]);
        if (is_null($message))
            return false;

        $roomUser = ChatRoomUser::findOne([
            'chat_user_id' => $session->getChatUser()->id,
            'room_id' => $message->room_id,
        ]);

        if (is_null($roomUser) || !self::can($roomUser, ChatRights::DELETE_MESSAGE))
        {
            $session->sendCommand(ChatCommands::SERVER_CHAT_DELETE_ERROR, [
                'error' => $session->t('matodor.chat', 'chat.access_denied')]);
            return false;
        }

        $this->deleteMessage($message);
        return true;
    }

    /**
     * Обработка запроса на удаление чат-диалога
     * @param ChatSession $session
     * @param array $payload ['roomId']
     * @return boolean
     */
    public function onChatDelete(ChatSession $session, $payload)
    {
        $roomUser = ChatRoomUser::findOne([
            'room_id' => $payload['roomId'],
            'chat_user_id' => $session->getChatUser()->id]);

        if (is_null($roomUser) || !$this->can($roomUser, ChatRights::DELETE_ROOM))
        {
            $session->sendCommand(ChatCommands::SERVER_CHAT_DELETE_ERROR, [
                'error' => $session->t('matodor.chat', 'chat.access_denied')]);
            return false;
        }

        $this->deleteRoom($roomUser->chatRoom);
        return true;
    }

    /**
     * Обработка входящего сообщения от пользователя
     *
     * @param ChatSession $session
     * @param array $payload ['text', 'roomId', 'attachments']
     * @return boolean
     */
    public function onChatMessage(ChatSession $session, $payload)
    {
        if ($session->connectedChat === null ||
            $session->connectedChat->id != $payload['roomId'])
        {
            return false;
        }

        $model = new ChatRoomMessage();
        $model->room_id = $session->connectedChat->id;
        $model->chat_user_id = $session->chatUser->id;
        $model->plain_text = $payload['text'];

        if ($model->save())
        {
            $data = $model->toArray();
            $data['attachments'] = [];

            if (   isset($payload['attachments']) &&
                is_array($payload['attachments']) &&
                   count($payload['attachments']) > 0)
            {
                /** @var ChatAttachment[] $attachments */
                $attachments = ChatAttachment::find()
                    ->where(['token' => $payload['attachments']])
                    ->all();

                foreach ($attachments as $attachment)
                {
                    $am = new ChatAttachmentToMessage();
                    $am->message_id = $model->id;
                    $am->attachment_id = $attachment->id;

                    if ($am->save())
                        $data['attachments'][$attachment->id] = $attachment->toArray();
                }
            }

            $users = $session->connectedChat->users;
            $this->worker->broadcast($users, ChatCommands::SERVER_CHAT_MESSAGE, $data);

            foreach ($users as $user)
            {
                if ($user->chat_user_id == $session->getChatUser()->id)
                    continue;

                $notFound = true;
                $userSessions = $this->worker->sessionManager->getSessions($user->chat_user_id);

                foreach ($userSessions as $userSession)
                {
                    if ($userSession->connectedChat !== null &&
                        $userSession->connectedChat->id == $model->room_id)
                    {
                        $notFound = false;
                        break;
                    }
                }

                if ($notFound)
                {
                    $user->has_unread = true;
                    $user->save();
                }
            }
        }
        else
        {
            $session->sendCommand(ChatCommands::SERVER_CHAT_MESSAGE_ERROR, [
                'error' => $model->getErrors()]);
            return false;
        }

        return true;
    }

    /**
     * Обработка запроса пользователя на отключение от диалога
     *
     * @param ChatSession $session
     * @param array
     * @return bool
     */
    public function onChatDisconnect(ChatSession $session, $payload)
    {
        if ($session->connectedChat === null)
            return false;

        $event = new RoomDisconnected();
        $event->worker = $this->worker;
        $event->chatRoom = $session->connectedChat;
        $this->trigger(self::RoomDisconnectedEvent, $event);
        $this->worker->log('ChatManager', "Session {$session->getId()} exit from room {$session->connectedChat->id}");
        $session->connectedChat = null;

        return true;
    }

    /**
     * Обработка запроса пользователя на подключение к диалогу
     *
     * @param ChatSession $session
     * @param array $payload ['token']
     * @return bool
     */
    public function onChatConnect(ChatSession $session, $payload)
    {
        $roomDataQuery = $session
            ->getChatUser()
            ->getRooms()
            ->where(['token' => $payload['token']]);

        $rooms = $session->getChatUser()->getRoomsWithData($roomDataQuery);

        if (empty($rooms))
        {
            $session->sendCommand(ChatCommands::SERVER_CHAT_CONNECT_ERROR, [
                'error' => $session->t('matodor.chat', 'chat.access_denied'),
                'token' => $payload['token']
            ]);

            return false;
        }

        $room = $rooms[0];
        $chatRoom = new ChatRoom();
        $chatRoom->setOldAttributes($room);
        $chatRoom->setAttributes($chatRoom->getOldAttributes(), false);

        $chatRoomUser = new ChatRoomUser();
        $chatRoomUser->setOldAttributes($room['users'][$session->getChatUser()->id]);
        $chatRoomUser->setAttributes($chatRoomUser->getOldAttributes(), false);

        if ($session->connectedChat !== null)
        {
            $session->sendCommand(ChatCommands::SERVER_CHAT_CONNECT_ERROR, [
                'error' => $session->t('matodor.chat', 'chat.already_connected'),
                'token' => $payload['token']
            ]);
            return false;
        }

        $event = new BeforeRoomConnect();
        $event->worker = $this->worker;
        $event->chatRoom = $chatRoom;
        $event->chatRoomUser = $chatRoomUser;
        $this->trigger(self::BeforeRoomConnectEvent, $event);

        if ($event->abort)
            return;

        if ($chatRoomUser->has_unread)
        {
            $room['has_unread'] = false;
            $room['users'][$chatRoomUser->chat_user_id]['has_unread'] = false;
            $chatRoomUser->has_unread = false;
            $chatRoomUser->save();
        }

        $session->connectedChat = $chatRoom;
        $session->sendCommand(ChatCommands::SERVER_CHAT_CONNECTED, $room);

        $joinEvent = new RoomConnected();
        $joinEvent->worker = $this->worker;
        $joinEvent->chatRoom = $chatRoom;
        $joinEvent->chatRoomUser = $chatRoomUser;
        $joinEvent->roomData = $room;
        $this->trigger(self::RoomConnectedEvent, $joinEvent);
        $this->worker->log('ChatManager', "Session {$session->getId()} joined to room {$chatRoom->id}");
        $this->onChatRequestHistory($session, ['time' => null, 'room' => $chatRoom]);

        return true;
    }

    /**
     * Обработка запроса пользователя на получение истории диалога
     *
     * @param ChatSession $session
     * @param array $payload
     * @return bool
     */
    public function onChatRequestHistory(ChatSession $session, $payload)
    {
        if ($session->connectedChat === null)
            return false;

        /** @var ChatRoom $chatRoom */

        if (isset($payload['room']) && $payload['room'] instanceof ChatRoom)
        {
            $chatRoom = $payload['room'];
        }
        else
        {
            $chatRoom = ChatRoom::find()
                ->where(['token' => $payload['token']])
                ->one();
        }

        if (is_null($chatRoom))
            return false;

        $messages = $chatRoom->getHistory($payload['time'], 20, true);
        $messages = array_reverse($messages);

        if (count($messages) > 0)
        {
            $lastTime = $messages[0]['create_time'];
            $left = $chatRoom->getLeftMessages($lastTime);

            $session->sendCommand(ChatCommands::SERVER_CHAT_HISTORY, [
                'roomId' => $chatRoom->id,
                'messages' => $messages,
                'left' => $left
            ]);

            return true;
        }

        return false;
    }
}
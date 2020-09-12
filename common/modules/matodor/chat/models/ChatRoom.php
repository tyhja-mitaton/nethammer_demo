<?php

namespace matodor\chat\models;

use matodor\chat\events\RoomUserAdded;
use Yii;
use matodor\chat\models\ChatRoomUser;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

/**
 * Сущность - чат-комната (беседа)
 *
 * @property integer $id Идентификатор
 * @property string $group Ключ группировки
 * @property string $token Токен доступа
 * @property string $title Заголовок чат комнаты
 * @property integer $create_time
 * @property integer $update_time
 *
 * @property ChatRoomMessage[] $messages
 * @property ChatRoomUser[] $users
 */
class ChatRoom extends ActiveRecord
{
    const RoomUserAddedEvent = 'RoomUserAddedEvent';

    public function behaviors()
    {
        return
        [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'create_time',
                'updatedAtAttribute' => 'update_time',
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['token', 'title'], 'required'],
            [['create_time', 'update_time'], 'integer'],
            [['token'], 'string', 'length' => 32],
            [['group', 'title'], 'string', 'max' => 256],
        ];
    }

    public static function tableName()
    {
        return '{{%chat_room}}';
    }

    /**
     * Поиск беседы по токену
     *
     * @param string $token
     * @return ChatRoom
     */
    public static function findByToken(string $token)
    {
        return self::findOne(['token' => $token]);
    }

    /**
     * Получение запроса списка чат-пользователей для беседы
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(ChatRoomUser::class, ['room_id' => 'id']);
    }

    /**
     * Получение списка сообщений для беседы
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMessages()
    {
        return $this
            ->hasMany(ChatRoomMessage::class, ['room_id' => 'id'])
            ->orderBy(['update_time' => SORT_DESC]);
    }

    /**
     * Получение истории сообщений для беседы
     *
     * @param integer|null $time Выборка сообщений до указанной отметки времени
     * @param integer $limit Лимит сообщений
     * @param bool $withAttachments Вернуть массив сообщений с прикрепленными файлами
     *
     * @return ChatRoomMessage[]|array
     */
    public function getHistory($time = null, int $limit = 10, bool $withAttachments = false)
    {
        /** @var ChatRoomMessage[]|array $messages */
        $messages = $this->getMessages()
            ->andFilterWhere(['<', 'create_time', $time])
            ->limit($limit)
            ->asArray()
            ->all();

        foreach ($messages as &$message)
        {
            if ($withAttachments)
            {
                $message['attachments'] = [];
                $model = new ChatRoomMessage();
                $model->setAttributes($message, false);
                $attachments = $model->attachments;

                foreach ($attachments as $attachment)
                    $message['attachments'][$attachment->id] = $attachment->toArray();
            }
            else
                $message['attachments'] = null;
        }

        return $messages;
    }

    /**
     * Возвращает количество сообщений до указанной отметки времени
     *
     * @param integer $time UNIX-timestamp
     * @return integer
     */
    public function getLeftMessages($time)
    {
        return $this->getMessages()
            ->andWhere(['<', 'create_time', $time])
            ->count();
    }

    /**
     * Добавляет чат-пользователя в беседу
     *
     * @param ChatUser $user
     * @param int $rights
     * @param bool $hasUnread
     * @param array $data Массив дополнительных данных, который будет передан в вызываемое событие RoomUserAdded
     * @return ChatRoomUser|false
     */
    public function addUser(ChatUser $user, int $rights = 0, bool $hasUnread = false, $data = null)
    {
        $roomUser = $this->getRoomUser($user);

        if (!is_null($roomUser))
            return $roomUser;

        $roomUser = new ChatRoomUser;
        $roomUser->has_unread = $hasUnread;
        $roomUser->chat_user_id = $user->id;
        $roomUser->room_id = $this->id;
        $roomUser->rights = $rights;

        if ($roomUser->save())
        {
            $event = new RoomUserAdded();
            $event->worker = Yii::$app->getModule('chat')->worker;
            $event->chatRoom = $this;
            $event->chatUser = $user;
            $event->roomUser = $roomUser;
            $event->payload = $data;
            $this->trigger(self::RoomUserAddedEvent, $event);

            return $roomUser;
        }

        return false;
    }

    /**
     * Возвращает пользователя чат-комнаты для указанного чат-пользователя
     *
     * @param ChatUser $user
     * @return ChatRoomUser
     */
    public function getRoomUser(ChatUser $user)
    {
        return $this->getUsers()
            ->where(['chat_user_id' => $user->id])
            ->one();
    }
}

?>
<?php
Yii::setAlias('@common', dirname(__DIR__));
Yii::setAlias('@frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('@backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('@console', dirname(dirname(__DIR__)) . '/console');

\yii\base\Event::on(
    \matodor\chat\core\ChatManager::class,
    \matodor\chat\core\ChatManager::RoomCreatedEvent, function ($event) {
        /** @var \matodor\chat\events\RoomCreated $event */
        /** @var \matodor\chat\ChatModule $chatModule  */

        $chatModule = Yii::$app->getModule('chat');
        $admin = \common\models\User::findOne(['username' => 'admin']);
        if ($admin === null) {
            return null;
        }

        $adminChatUser = \matodor\chat\models\ChatUser::findOne(['user_id' => $admin->id]);
        if ($adminChatUser === null) {
            $adminChatUser = $chatModule->createChatUser($admin->id);
        }

        $event->chatRoom->addUser($adminChatUser, \matodor\chat\core\ChatRights::OWNER, true);
        $event->chatRoom->addUser($event->session->getChatUser());

        $message = new \matodor\chat\models\ChatRoomMessage();
        $message->room_id = $event->chatRoom->id;
        $message->chat_user_id = $adminChatUser->id;
        $message->plain_text = 'Мы свяжется с вами в ближайшее время.';
        $message->save();
    }
);

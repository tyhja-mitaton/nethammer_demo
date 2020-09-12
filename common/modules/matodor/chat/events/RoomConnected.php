<?php

namespace matodor\chat\events;

use matodor\chat\core\ChatSession;
use matodor\chat\models\ChatRoom;
use matodor\chat\models\ChatRoomUser;

class RoomConnected extends BaseEvent
{
    /**
     * @var ChatSession
     */
    public $session;

    /**
     * Модель чат-комнаты, к которой подключился пользователб
     * @var ChatRoom
     */
    public $chatRoom;

    /**
     * @var ChatRoomUser
     */
    public $chatRoomUser;

    /**
     * Модель чат-комнаты в виде массива, с дополнительными данными: users, lastMessage, ...
     * @var array
     */
    public $roomData;
}

?>
<?php

namespace matodor\chat\events;

use matodor\chat\core\ChatSession;
use matodor\chat\models\ChatRoom;
use matodor\chat\models\ChatRoomUser;

class RoomCreated extends BaseEvent
{
    /**
     * @var ChatSession
     */
    public $session;

    /**
     * Модель созданной чат-комнаты
     * @var ChatRoom
     */
    public $chatRoom;
}

?>
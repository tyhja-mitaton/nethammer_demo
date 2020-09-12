<?php

namespace matodor\chat\events;

use matodor\chat\models\ChatRoom;
use matodor\chat\models\ChatRoomUser;
use matodor\chat\models\ChatUser;

class RoomUserAdded extends BaseEvent
{
    /**
     * @var array
     */
    public $payload;

    /**
     * @var ChatUser
     */
    public $chatUser;

    /**
     * @var ChatRoomUser
     */
    public $roomUser;

    /**
     * Модель созданной чат-комнаты
     * @var ChatRoom
     */
    public $chatRoom;
}

?>
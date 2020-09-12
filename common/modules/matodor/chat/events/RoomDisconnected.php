<?php

namespace matodor\chat\events;

use matodor\chat\core\ChatSession;
use matodor\chat\models\ChatRoom;
use matodor\chat\models\ChatRoomUser;

class RoomDisconnected extends BaseEvent
{
    /**
     * @var ChatSession
     */
    public $session;

    /**
     * @var ChatRoom
     */
    public $chatRoom;
}

?>
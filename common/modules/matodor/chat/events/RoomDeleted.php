<?php

namespace matodor\chat\events;

use matodor\chat\models\ChatRoom;

class RoomDeleted extends BaseEvent
{
    /**
     * @var ChatRoom
     */
    public $chatRoom;
}

?>
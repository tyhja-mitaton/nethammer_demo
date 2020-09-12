<?php

namespace matodor\chat\events;

use matodor\chat\core\ChatSession;
use matodor\chat\models\ChatRoom;
use matodor\chat\models\ChatRoomUser;

class BeforeDeleteEmptyRoom extends AbortableEvent
{
    /**
     * @var ChatRoom
     */
    public $chatRoom;
}

?>
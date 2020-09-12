<?php

namespace matodor\chat\events;

use matodor\chat\core\ChatSession;
use matodor\chat\models\ChatRoom;
use matodor\chat\models\ChatRoomUser;

class BeforeRoomConnect extends AbortableEvent
{
    /**
     * @var ChatSession
     */
    public $session;

    /**
     * @var ChatRoom
     */
    public $chatRoom;

    /**
     * @var ChatRoomUser
     */
    public $chatRoomUser;
}

?>
<?php

namespace matodor\chat\events;

use matodor\chat\core\ChatSession;
use matodor\chat\models\ChatRoom;
use matodor\chat\models\ChatRoomUser;
use matodor\chat\models\forms\CreateDialog;

class BeforeCreateRoom extends AbortableEvent
{
    /**
     * @var ChatRoom
     */
    public $chatRoom;

    /**
     * @var ChatSession
     */
    public $session;
}

?>
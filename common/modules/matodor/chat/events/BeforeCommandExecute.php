<?php

namespace matodor\chat\events;

use matodor\chat\core\ChatSession;
use Workerman\Worker;

class BeforeCommandExecute extends AbortableEvent
{
    /**
     * @var ChatSession
     */
    public $session;

    /**
     * @var WsMessage
     */
    public $message;
}

?>
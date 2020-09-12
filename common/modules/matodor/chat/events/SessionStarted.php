<?php

namespace matodor\chat\events;

use matodor\chat\core\ChatSession;
use Workerman\Worker;

class SessionStarted extends BaseEvent
{
    /**
     * @var ChatSession
     */
    public $session;
}

?>
<?php

namespace matodor\chat\events;

use Workerman\Worker;
use Workerman\Connection\TcpConnection;

class BeforeSessionStart extends BaseEvent
{
    /**
     * @var TcpConnection
     */
    public $connection;

    /**
     * @var boolean Отвергнуть подключение
     */
    public $forceDisconnect = false;
}

?>
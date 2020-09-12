<?php

namespace matodor\chat\events;

use matodor\chat\core\ChatWorker;
use yii\base\Event;

/**
 * Базовый класс для всех событий чат-модуля
 */
class BaseEvent extends Event
{
    /**
     * @var ChatWorker
     */
    public $worker;
}

?>
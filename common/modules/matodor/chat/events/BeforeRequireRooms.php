<?php

namespace matodor\chat\events;

use matodor\chat\core\ChatSession;
use Workerman\Worker;
use yii\db\ActiveQuery;

class BeforeRequireRooms extends AbortableEvent
{
    /**
     * @var ChatSession
     */
    public $session;

    /**
     * Запрос для выборки чат-комнат пользователя
     *
     * @var ActiveQuery $query
     * @see [[ChatUser::getRooms()]]
     */
    public $query;
}

?>
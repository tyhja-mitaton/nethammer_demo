<?php

namespace matodor\chat\core;

use Yii;
use matodor\chat\core\BaseChatComponent;
use matodor\chat\models\ChatUser;
use Workerman\Connection\TcpConnection;

class SessionManager extends BaseChatComponent
{
    /**
     * Массив чат-сессий пользователей
     * Ключи - ID из ChatUser, значение - массив сессий
     *
	 * @var array
     */
    protected $sessions;

    public function __construct()
    {
        $this->sessions = [];
    }

    /**
     * Создание новой чат-сессии
     *
     * @param TcpConnection $connection
     * @param ChatUser $chatUser
     * @param array $cookies
     *
     * @return ChatSession
     */
    public function createSession($connection, $chatUser, $cookies)
    {
        /** @var ChatSession $session */
        $connection->chatUserId = $chatUser->id;
        $session = Yii::createObject(ChatSession::class, [$connection, $chatUser, $cookies]);
        $this->sessions[$chatUser->id][$session->getId()] = $session;
        $this->worker->log('SessionManager', "Create session {$session->getId()}");

        return $session;
    }

    /**
     * Закрытие чат-сессии
     *
     * @param TcpConnection $connection
     *
     * @return void
     */
    public function closeSession($connection)
    {
        $session = $this->getSession($connection);
        $session->connectedChat = null;

        if ($session === null)
            $this->worker->log('SessionManager', '[closeSession] No session for connection');
        else
        {
            unset($this->sessions[$connection->chatUserId][$session->getId()]);

            if (empty($this->sessions[$connection->chatUserId]))
                unset($this->sessions[$connection->chatUserId]);

            $this->worker->log('SessionManager', "Close session {$session->getId()}");
        }
    }

    /**
     * Получение чат-сессии
     *
     * @param TcpConnection $connection
     *
	 * @return ChatSession|null
     */
    public function getSession($connection)
    {
        if (isset($this->sessions[$connection->chatUserId]) &&
            isset($this->sessions[$connection->chatUserId][$connection->id])
        )
        {
            return $this->sessions[$connection->chatUserId][$connection->id];
        }

        return null;
    }

    /**
     * Получение открытых сессий для чат-пользователя
     *
     * @param integer $chatUserId Идентификатор чат-пользователя
     *
	 * @return ChatSession[]
     */
    public function getSessions($chatUserId)
    {
        if (isset($this->sessions[$chatUserId]))
            return $this->sessions[$chatUserId];
        return [];
    }
}
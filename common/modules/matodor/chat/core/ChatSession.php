<?php

namespace matodor\chat\core;

use Yii;

use Workerman\Connection\TcpConnection;
use matodor\chat\models\ChatRoom;
use matodor\chat\models\ChatUser;

class ChatSession extends BaseChatComponent
{
    /**
     * @var yii\web\Cookie[]
     */
    protected $cookies;

    /**
     * @var TcpConnection
     */
    protected $connection;

    /**
     * @var ChatUser
     */
    protected $chatUser;

    /**
     * @var ChatRoom
     */
    public $connectedChat;

    /**
     * @var array
     */
    public $requestData;

    public function __construct($connection, $chatUser, $cookies)
    {
        $this->connection = $connection;
        $this->cookies = $cookies;
        $this->chatUser = $chatUser;
        $this->connectedChat = null;
    }

    public function getLanguage()
    {
        return $this->requestData['language'] ?? Yii::$app->language;
    }

    /**
     * Перевод сообщений для пользователя
     * @see Yii::t
     * @param string $category
     * @param string $message
     * @param array $params
     * @return void
     */
    public function t($category, $message, $params = [])
    {
        return Yii::t($category, $message, $params, $this->getLanguage());
    }

    /**
     * Возвращает модель ChatUser для сессии пользователя
     *
     * @return ChatUser
     */
    public function getChatUser()
    {
        return $this->chatUser;
    }

    /**
     * Является ли пользователь гостем в системе
     *
     * @return boolean
     */
    public function isGuest()
    {
        return is_null($this->getChatUser()->user_id);
    }

    /**
     * Возвращает tcp соединение
     *
     * @return TcpConnection
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * Возвращает идентификатор чат-сессии
     *
     * @return integer
     */
    public function getId()
    {
        return $this->connection->id;
    }

    /**
     * Проверяет наличие cookie в массиве
     *
     * @param string $key
     * @return boolean
     */
    public function hasCookie($key)
    {
        return isset($this->cookies[$key]);
    }

    /**
     * Возвращает cookie для указанного ключа
     *
     * @param string $key
     * @return yii\web\Cookie
     */
    public function getCookie($key)
    {
        return $this->cookies[$key];
    }

    public function sendCommand(int $command, array $payload = null)
    {
        $this->send(new WsMessage($command, $payload));
    }

    public function send(WsMessage $message)
    {
        $this->connection->send($message->toJson());
    }
}

?>
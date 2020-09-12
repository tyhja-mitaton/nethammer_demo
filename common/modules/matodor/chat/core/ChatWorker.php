<?php
//https://github.com/walkor/Workerman
//https://sergeyzhuk.me/2017/06/06/phpreact-event-loop/

namespace matodor\chat\core;

use Exception;
use Yii;
use yii\base\Component;
use Workerman\Worker;
use Workerman\Connection\TcpConnection;
use Workerman\Lib\Timer;

use matodor\chat\core\ChatCommands;
use matodor\chat\core\ChatManager;
use matodor\chat\core\SessionManager;
use matodor\chat\models\ChatUser;
use matodor\chat\events\BeforeCommandExecute;
use matodor\chat\events\BeforeSessionStart;
use matodor\chat\events\SessionStarted;
use matodor\chat\events\WorkerStarted;
use matodor\chat\models\ChatRoomUser;

/**
 *
 */
class ChatWorker extends Component
{
    const WorkerStartedEvent = 'WorkerStartedEvent';
    const BeforeSessionStartEvent = 'BeforeSessionStartEvent';
    const SessionStartedEvent = 'SessionStartedEvent';
    const BeforeCommandExecuteEvent = 'BeforeCommandExecuteEvent';

    /**
	 * @var bool
     */
    public $showLog = true;

    /**
	 * @var string
     */
    public $bindIp = '127.0.0.1';

    /**
	 * @var int
     */
    public $bindPort = 9090;

    /**
	 * @var string
     */
    public $realm = 'chat';

    /**
	 * @var string
     */
    public $cookieValidationKey = '';

    /**
	 * @var boolean
     */
    public $enableCookieValidation = true;

    /**
     * Автоматическое удаление пустых чат-комнат
	 * @var boolean
     */
    public $deleteEmptyRooms = true;

    /**
     * Интервал проверки и удаления пустых чат-комнат (не имеющих сообщений)
	 * @var integer
     */
    public $deleteEmptyRoomsInterval = 86400;

    /**
     * Интервал переподключения к базе данных
	 * @var integer
     */
    public $doDatabaseReconnectInterval = 120;

    /**
	 * @var string[]
     */
    public $csrfParams = [];

    /**
	 * @var ChatCommands
     */
    public $commands;

    /**
	 * @var ChatManager
     */
    public $chatManager;

    /**
	 * @var SessionManager
     */
    public $sessionManager;

    /**
     * @var array
     */
    public $wsContextOption = [];

    /**
     * @var boolean
     */
    public $useWss = false;

    /**
	 * @var Worker
     */
    protected $ws_worker;

    public function run()
    {
        $this->ws_worker = new Worker("websocket://{$this->bindIp}:{$this->bindPort}/{$this->realm}", $this->wsContextOption);

        if ($this->useWss)
            $this->ws_worker->transport = 'ssl';

        $this->ws_worker->name = 'chat_worker';
        $this->ws_worker->count = 1;
        $this->ws_worker->onWorkerStart = array($this, 'onWorkerStart');
        $this->ws_worker->onConnect = array($this, 'onConnect');
        $this->ws_worker->onMessage = array($this, 'onMessage');
        $this->ws_worker->onClose = array($this, 'onClose');
        $this->ws_worker->onWebSocketConnect = array($this, 'onWebSocketConnect');

        $this->chatManager = Yii::createObject(ChatManager::class);
        $this->sessionManager = Yii::createObject(SessionManager::class);
        $this->commands = Yii::createObject(ChatCommands::class);

        Worker::runAll();
    }

    /**
     * Вызывается после инициализации и старта всех экземпляров Workerman\Worker
     * Генерирует событие WorkerStarted
     *
     * @param Workerman\Worker $worker
     * @return void
     */
    public function onWorkerStart($worker)
    {
        Timer::add($this->doDatabaseReconnectInterval,   [$this, 'doDatabaseReconnect']);

        if ($this->deleteEmptyRooms)
        {
            $this->chatManager->deleteEmptyRooms();
            Timer::add($this->deleteEmptyRoomsInterval, [$this->chatManager, 'deleteEmptyRooms']);
        }

        $event = new WorkerStarted();
        $event->worker = $this;
        $this->trigger(self::WorkerStartedEvent, $event);
        $this->log('ChatWorker', 'Worker started');
    }

    /**
     * Вывод сообщения в консоль
     *
     * @param string $type
     * @param string $message
     * @return void
     */
    public function log(string $type, string $message)
    {
        if ($this->showLog)
            Worker::log("[" . date('Y-m-d H:i:s') . "][$type] $message");
    }

    /**
     * Рассылка команды группе пользователей
     * @param ChatUser[]|ChatRoomUser[]|array $users
     * @param string $type
     * @param array $payload
     * @return void
     */
    public function broadcast($users, int $command, array $payload)
    {
        foreach ($users as $user)
        {
            $chatUserId = null;

            if ($user instanceof ChatUser)
                $chatUserId = $user->id;
            else if ($user instanceof ChatRoomUser)
                $chatUserId = $user->chat_user_id;
            else if (isset($user['chatUserId']))
                $chatUserId = $user['chatUserId'];

            if ($chatUserId === null)
                continue;

            $sessions = $this->sessionManager->getSessions($chatUserId);
            foreach ($sessions as $session)
                $session->sendCommand($command, $payload);
        }
    }

    /**
     * @return Worker
     */
    public function getWorker()
    {
        return $this->ws_worker;
    }

    /**
     * Вызывается после успешного "рукопожатия" сервера и клиента
     * В этот момент доступны глобальные переменные $_GET, $_SERVER, $_SESSION, $_COOKIE
     *
	 * @param Workerman\Connection\TcpConnection $connection Подключение
	 * @param string $buffer Содержит заголовки запроса в одной строке
     * @var $identity yii\web\IdentityInterface
     */
    public function onWebSocketConnect($connection, $buffer)
    {
        $event = new BeforeSessionStart();
        $event->worker = $this;
        $event->connection = $connection;
        $this->trigger(self::BeforeSessionStartEvent, $event);

        if ($event->forceDisconnect)
        {
            $connection->close();
            return;
        }

        $token = $_GET['token'] ?? null;
        $csrfParam = $_GET['csrfParam'] ?? null;
        $csrfToken = $_GET['csrfToken'] ?? null;

        if (empty($token) ||
            empty($csrfToken) ||
            empty($csrfParam))
        {
            $this->log('ChatWorker', '[onWebSocketConnect] Bad request headers');
            $connection->close();
            return;
        }

        $chatUser = ChatUser::findOne(['token' => $token]);
        if (is_null($chatUser))
        {
            $this->log('ChatWorker', '[onWebSocketConnect] ChatUser not found by given token');
            $connection->close();
            return;
        }

        /** @var yii\web\Cookie[] $cookies */
        $cookies = [];

        if ($this->enableCookieValidation)
        {
            if ($this->cookieValidationKey == '')
                throw new Exception('CookieValidationKey must be configured with a secret key.');

            foreach ($_COOKIE as $name => $value)
            {
                if (!is_string($value))
                    continue;

                $data = Yii::$app->getSecurity()->validateData($value, $this->cookieValidationKey);
                if ($data === false)
                    continue;

                $data = @unserialize($data);

                if (is_array($data) && isset($data[0], $data[1]) && $data[0] === $name)
                {
                    $cookies[$name] = Yii::createObject([
                        'class' => 'yii\web\Cookie',
                        'name' => $name,
                        'value' => $data[1],
                        'expire' => null,
                    ]);
                }
            }
        }
        else
        {
            foreach ($_COOKIE as $name => $value)
            {
                $cookies[$name] = Yii::createObject([
                    'class' => yii\web\Cookie::class,
                    'name' => $name,
                    'value' => $value,
                    'expire' => null,
                ]);
            }
        }

        $csrfToken = Yii::$app->getSecurity()->unmaskToken($csrfToken);
        $csrfNotValid = true;

        if (isset($cookies[$csrfParam]))
            $csrfNotValid = $cookies[$csrfParam]->value != $csrfToken;

        if ($csrfNotValid)
        {
            $this->log('ChatWorker', '[onWebSocketConnect] Drop client with invalid csrf token');
            $connection->close();
            return;
        }

        unset($_GET['token']);
        unset($_GET['csrfParam']);
        unset($_GET['csrfToken']);

        $session = $this->sessionManager->createSession($connection, $chatUser, $cookies);
        $session->requestData = $_GET;
        $profile = $session->getChatUser()->profile;

        $session->sendCommand(ChatCommands::SERVER_SUCCESS_AUTH, [
            'chatUserId' => $session->getChatUser()->id,
            'isGuest' => $session->isGuest(),
            'profile' => isset($profile) ? $profile->toArray() : null,
        ]);

        $event = new SessionStarted();
        $event->worker = $this;
        $event->session = $session;
        $this->trigger(self::SessionStartedEvent, $event);
    }

    public function doDatabaseReconnect()
    {
        Yii::$app->db->close();
        Yii::$app->db->open();
    }

    /**
     * @param Workerman\Connection\TcpConnection $connection
     */
    public function onMessage($connection, $data)
    {
        $session = $this->sessionManager->getSession($connection);
        if ($session === null)
        {
            $this->log('ChatWorker', '[onMessage] No session for connection');
            return;
        }

        $message = WsMessage::fromJson($data);
        if ($message === null)
        {
            $this->log('ChatWorker', "[onMessage] Skip invalid message ($data)");
            return;
        }

        $event = new BeforeCommandExecute();
        $event->worker = $this;
        $event->session = $session;
        $event->message = $message;
        $this->trigger(self::BeforeCommandExecuteEvent, $event);

        if ($event->abort === false)
            $this->commands->tryExecute($session, $message);
    }

    /**
     * Вызывается в первую очередь после успешного подключения клиента
     *
     * @param Workerman\Connection\TcpConnection $connection
     */
    public function onConnect($connection)
    {
        $connection->chatUserId = null;
    }

    /**
     * Вызывается при закрытие соединения
     *
     * @param Workerman\Connection\TcpConnection $connection
     *
     * @return void
     */
    public function onClose($connection)
    {
        if (is_null($connection->chatUserId))
            return;

        $this->sessionManager->closeSession($connection);
    }
}

?>

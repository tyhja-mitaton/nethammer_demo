<?php

namespace matodor\chat\core;
use matodor\chat\core\WsMessage;
use matodor\chat\core\ChatSession;
use matodor\chat\core\BaseChatComponent;

class ChatCommands extends BaseChatComponent
{
    // messages from client to server
    const CLIENT_GET_CHAT_LIST          = 1;
    const CLIENT_CHAT_CONNECT           = 3;
    const CLIENT_CHAT_DISCONNECT        = 4;
    const CLIENT_CHAT_MESSAGE           = 5;
    const CLIENT_CHAT_HISTORY           = 6;
    const CLIENT_CHAT_DELETE            = 7;
    const CLIENT_CHAT_DELETE_MESSAGE    = 8;
    const CLIENT_SET_INFO               = 9;
    const CLIENT_CHAT_CREATE            = 10;
    const CLIENT_CHAT_ATTACHMENTS       = 11;

    // messages to client from server
    const SERVER_SUCCESS_AUTH           = 100;
    const SERVER_CHAT_DELETE            = 101;
    const SERVER_CHAT_LIST              = 102;
    const SERVER_CHAT_CONNECT_ERROR     = 103;
    const SERVER_CHAT_CONNECTED         = 104;
    const SERVER_CHAT_HISTORY           = 105;
    const SERVER_CHAT_DISCONNECTED      = 106;
    const SERVER_CHAT_MESSAGE_ERROR     = 107;
    const SERVER_CHAT_MESSAGE           = 108;
    const SERVER_CHAT_DELETE_ERROR      = 109;
    const SERVER_CHAT_DELETE_MESSAGE    = 110;
    const SERVER_SET_INFO_ERROR         = 111;
    const SERVER_SET_INFO_SUCCESS       = 112;
    const SERVER_CHAT_CREATE_ERROR      = 113;
    const SERVER_CHAT_CREATE_SUCCESS    = 114;
    const SERVER_CHAT_ATTACHMENT_ERROR  = 115;

    /**
     * Массив доступных комманд, для вызова со стороны клиента
     * Ключ - комманда (число), значение - массив, где
     *    required - список обязательных параметров
     *    method - вызываемый метод на target объекте
     *    target - ссылка на объект, содержащий вызываемый метод
     *
     * Пример:
     *    ChatCommands::CLIENT_GET_CHAT_LIST => [
     *         'required' => ['userId'],
     *         'method' => 'onGetChatList',
     *         'target' => target object
     *     ],
     */
    public $commands = [];

    /**
     * @inheritDoc
     */
    public function init()
    {
        $this->commands[self::CLIENT_GET_CHAT_LIST] = [
            'method' => 'onGetChatList',
            'target' => $this->worker->chatManager
        ];

        $this->commands[self::CLIENT_CHAT_CONNECT] = [
            'required' => ['token'],
            'method' => 'onChatConnect',
            'target' => $this->worker->chatManager
        ];

        $this->commands[self::CLIENT_CHAT_DISCONNECT] = [
            'method' => 'onChatDisconnect',
            'target' => $this->worker->chatManager
        ];

        $this->commands[self::CLIENT_CHAT_MESSAGE] = [
            'required' => ['text', 'roomId'],
            'method' => 'onChatMessage',
            'target' => $this->worker->chatManager
        ];

        $this->commands[self::CLIENT_CHAT_HISTORY] = [
            'required' => ['time', 'token'],
            'method' => 'onChatRequestHistory',
            'target' => $this->worker->chatManager
        ];

        $this->commands[self::CLIENT_CHAT_DELETE] = [
            'required' => ['roomId'],
            'method' => 'onChatDelete',
            'target' => $this->worker->chatManager
        ];

        $this->commands[self::CLIENT_CHAT_DELETE_MESSAGE] = [
            'required' => ['messageId'],
            'method' => 'onChatDeleteMessage',
            'target' => $this->worker->chatManager
        ];

        $this->commands[self::CLIENT_SET_INFO] = [
            'method' => 'onClientSetInfo',
            'target' => $this->worker->chatManager
        ];

        $this->commands[self::CLIENT_CHAT_CREATE] = [
            'method' => 'onClientCreateChat',
            'target' => $this->worker->chatManager
        ];

        $this->commands[self::CLIENT_CHAT_ATTACHMENTS] = [
            'required' => ['attachments', 'roomId'],
            'method' => 'onClientSendAttachment',
            'target' => $this->worker->chatManager
        ];
    }

    /**
     * Обрабатывает входящие комманды пользователей (remote procedure call)
     *
     * @param ChatSession $session
     * @param WsMessage $socketMessage
     * @return boolean
     */
    public function tryExecute(ChatSession $session, WsMessage $socketMessage)
    {
        $payload = $socketMessage->getPayload();
        $command = intval($socketMessage->getCommand());

        if (!isset($this->commands[$command]))
        {
            $this->worker->log('ChatCommands', "[tryExecute] No such command ($command)");
            return false;
        }

        if (!isset($this->commands[$command]['target']))
        {
            $this->worker->log('ChatCommands', "[tryExecute] Target object not set ($command)");
            return false;
        }

        if (!isset($this->commands[$command]['method']))
        {
            $this->worker->log('ChatCommands', "[tryExecute] Method not set ($command)");
            return false;
        }

        if (isset($this->commands[$command]['required']))
        {
            foreach($this->commands[$command]['required'] as $value)
            {
                if (isset($payload[$value]) === false)
                {
                    $this->worker->log('ChatCommands', "Payload not contains $value");
                    return;
                }
            }
        }

        try {
            \call_user_func_array([
                $this->commands[$command]['target'],
                $this->commands[$command]['method'],
            ], [$session, $payload]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}

?>
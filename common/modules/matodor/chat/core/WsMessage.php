<?php

namespace matodor\chat\core;

class WsMessage
{
    /**
     * @var int
     */
    private $_command = null;

    /**
     * @var array
     */
    private $_payload = null;

    public function __construct(int $command, $payload)
    {
        $this->_command = $command;
        $this->_payload = $payload;
        $this->_valid = true;
    }

    /**
     * @return WsMessage
     */
    public static function fromJson(string $jsonData)
    {
        $data = json_decode($jsonData, true);

        if (is_null($data))
            return null;

        if (!isset($data['command']))
            return null;

        if (!isset($data['payload']))
            return new WsMessage($data['command'], []);

        return new WsMessage($data['command'], $data['payload']);
    }

    /**
     * @return string
     */
    public function toJson()
    {
        return json_encode([
            'command' => $this->getCommand(),
            'payload' => $this->getPayload()
        ]);
    }

    /**
     * Возвращает идентификатор команды
     *
     * @return int
     */
    public function getCommand()
    {
        return $this->_command;
    }

    /**
     * Возвращает передаваемые данные
     *
     * @return void
     */
    public function &getPayload()
    {
        return $this->_payload;
    }
}

?>
<?php

namespace matodor\chat\events;

class AbortableEvent extends BaseEvent
{
    /**
     * Прервать выполнение комманды
     *
     * @var boolean
     */
    public $abort = false;

    /**
     * Причина прерывания события
     *
     * @var boolean
     */
    public $abortReason = '';
}

?>
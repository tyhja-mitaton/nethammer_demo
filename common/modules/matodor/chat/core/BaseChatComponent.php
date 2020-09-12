<?php

namespace matodor\chat\core;

use Yii;
use yii\base\Component;

/**
 * @property ChatWorker $worker
 */
abstract class BaseChatComponent extends Component
{
    private static $_worker = null;

    /**
     * @return \matodor\chat\core\ChatWorker
     */
    protected function getWorker()
    {
        if (self::$_worker === null)
            self::$_worker = Yii::$app->getModule('chat')->worker;

        return self::$_worker;
    }
}

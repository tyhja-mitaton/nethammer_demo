<?php

namespace matodor\chat\commands;

use Yii;

class ListenerController extends \yii\console\Controller
{
    public function actionRun()
    {
        /** @var \matodor\chat\core\ChatWorker $chatWorker  */
        /** @var \matodor\chat\ChatModule $chatModule  */

        // unix OS
        if (DIRECTORY_SEPARATOR !== '\\')
        {
            global $argv;
            unset($argv[1]);
            $argv = array_values(array_filter($argv));
        }
        else
        {
            // windows code here
        }

        $chatModule = Yii::$app->getModule('chat');
        $chatWorker = $chatModule->worker;
        $chatWorker->run();
    }
}

?>
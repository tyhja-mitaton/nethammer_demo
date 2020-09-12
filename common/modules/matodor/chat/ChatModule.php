<?php

namespace matodor\chat;

use Yii;
use yii\base\BootstrapInterface;
use yii\base\Module as BaseModule;
use yii\base\Event as BaseEvent;
use yii\db\ActiveRecord;
use dektrium\user\models\User as DektriumUser;
use matodor\chat\core\ChatWorker;
use matodor\chat\models\ChatUser;
use yii\helpers\FileHelper;

/**
 * @property ChatWorker $worker
 */
class ChatModule extends BaseModule implements BootstrapInterface
{
    /**
     * Ключ для выборки токена гостя из Cookie
     *
     * @var string
     */
    public $chatTokenGuestKey = 'chat_token_guest';

    public $uploadedFilesPath = '@console/runtime/chat/files';

    /**
     * @var array Правила, которые будут использоваться в управлении URL.
     */
    public $urlRules = [
        'common/<action:[\w-]+>' => 'chat/<action>'
    ];

    public function init()
    {
        parent::init();
    }

    public static function isNullOrEmptyString($str)
    {
        return !isset($str) || trim($str) === '';
    }

    /**
     * @return string
     */
    public static function getRandomId($maxLength = 8)
    {
        return substr(bin2hex(random_bytes(16)), 0, $maxLength);
    }

    /**
     * Добавление нового пользователя чата
     *
     * @param integer|null $userId ID Yii2 пользователя в системе
     * @return ChatUser|null
     */
    public function createChatUser($userId)
    {
        $chatUser = new ChatUser();
        $chatUser->token = Yii::$app->getSecurity()->generateRandomString();
        $chatUser->user_id = $userId;

        if ($chatUser->save())
            return $chatUser;
        return null;
    }

    public function bootstrap($app)
    {
        FileHelper::createDirectory(Yii::getAlias($this->uploadedFilesPath));
        Yii::setAlias('@matodor/chat', __DIR__);

        if ($app instanceof \yii\console\Application)
            $this->controllerNamespace = 'matodor\chat\commands';
        else
        {
            /** @var yii\web\Application $app */
            $this->controllerNamespace = 'matodor\chat\controllers';

            $configUrlRule = [
                'prefix' => 'chat',
                'rules'  => $this->urlRules,
                'class' => yii\web\GroupUrlRule::class
            ];

            $rule = Yii::createObject($configUrlRule);
            $app->urlManager->addRules([$rule], false);

            BaseEvent::on(DektriumUser::class, ActiveRecord::EVENT_AFTER_INSERT, function ($event) {
                /** @var BaseEvent $event */
                /** @var DektriumUser $user */

                $user = $event->sender;
                $this->createChatUser($user->id);
            });

            BaseEvent::on(DektriumUser::class, ActiveRecord::EVENT_AFTER_DELETE, function ($event) {
                /** @var BaseEvent $event */
                /** @var DektriumUser $user */

                $user = $event->sender;
                ChatUser::deleteAll(['user_id' => $user->id]);
            });
        }
    }
}

?>

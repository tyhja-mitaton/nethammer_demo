<?php

namespace matodor\chat\widgets;

use Yii;
use yii\base\Widget;
use yii\widgets\ActiveFormAsset;
use yii\validators\ValidationAsset;
use yii\web\View;
use matodor\chat\assets\ChatAssets;
use matodor\chat\models\ChatUser;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\JsExpression;

class Chat extends Widget
{
    public $options = [];

    public function init()
    {
        parent::init();
        ChatAssets::register($this->getView());
        ActiveFormAsset::register($this->getView());
        ValidationAsset::register($this->getView());
    }

    public function run()
    {
        /** @var \matodor\chat\core\ChatWorker $chatWorker  */
        /** @var \matodor\chat\ChatModule $chatModule  */
        /** @var \matodor\chat\models\ChatUser|null $chatUser */

        if (isset($this->getView()->js[View::POS_BEGIN]['chat_scripts_key']))
            return;

        $chatUser = null;
        $chatModule = Yii::$app->getModule('chat');
        $chatWorker = $chatModule->worker;
        $options = [
            'ip' => $_SERVER['SERVER_NAME'],
            'useWss' => $chatWorker->useWss,
            'port' => $chatWorker->bindPort,
            'realm' => $chatWorker->realm,
            'requestParams' => [
                'token' => '',
                'language' => Yii::$app->language
            ],
            'schema' => [
                'get-form' => Url::toRoute(['chat/chat/get-form']),
                'upload' => Url::toRoute(['chat/chat/upload-file']),
                'download' => Url::toRoute(['chat/chat/download-file']),
            ],
        ];

        if (Yii::$app->user->getIsGuest())
        {
            if (Yii::$app->request->cookies->has($chatModule->chatTokenGuestKey))
            {
                $options['requestParams']['token'] = Yii::$app->request->cookies->getValue($chatModule->chatTokenGuestKey);
                $chatUser = ChatUser::findOne(['token' => $options['requestParams']['token']]);
            }

            if (is_null($chatUser))
            {
                $chatUser = $chatModule->createChatUser(null);
                $options['requestParams']['token'] = $chatUser->token;

                Yii::$app->response->cookies->add(new \yii\web\Cookie([
                    'name' => $chatModule->chatTokenGuestKey,
                    'value' => $chatUser->token,
                    'expire' => time() + 86400 * 365 * 10, // 10 years
                ]));
            }
        }
        else
        {
            $userId = Yii::$app->user->getIdentity()->getId();
            $chatUser = ChatUser::findOne(['user_id' => $userId]);

            if (is_null($chatUser))
                $chatUser = $chatModule->createChatUser($userId);

            $options['requestParams']['token'] = $chatUser->token;
        }

        $profile = $chatUser->profile;
        $options['isGuest'] = is_null($chatUser->user_id);
        $options['chatUserId'] = $chatUser->id;
        $options['profile'] = is_null($profile) ? null : $profile->toArray();

        $options = ArrayHelper::merge($options, $this->options);
        $options = json_encode($options, JSON_FORCE_OBJECT);

        $translations = require __DIR__ . '/../translation/translation.php';
        $js = [];
        $js[] = "if (typeof Chat == \"undefined\" || !Chat) { var Chat = {}; }";
        $js[] = "Chat.options = $options;";
        $js[] = "Chat.translation = {messages: {}};";

        foreach ($translations as $key => $translate)
            $js[] = "Chat.translation.messages['$key'] = '$translate';";

        if (YII_ENV_DEV)
            $js[] = 'CHAT_DEBUG = true;';

        $this->getView()->registerJs(implode("\n", $js), View::POS_BEGIN, 'chat_scripts_key');
        $this->getView()->registerJs('moment.locale(\'' . Yii::$app->language .'\');', View::POS_END);
    }
}

?>
<?php

namespace matodor\chat\controllers;

use Exception;
use matodor\chat\models\ChatAttachment;
use matodor\chat\models\ChatUser;
use matodor\chat\models\forms\SetInfo;
use Yii;
use yii\web\Response;
use yii\web\Controller;
use yii\widgets\ActiveForm;
use yii\filters\AccessControl;
use yii\web\UnauthorizedHttpException;
use yii\web\BadRequestHttpException;
use yii\web\UploadedFile;

class ChatController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['?', '@'],
                    ],
                ],
            ],
        ];
    }

    public function actionGetForm($formName)
    {
        Yii::$app->response->format = Response::FORMAT_HTML;

        if (!in_array($formName, ['SetInfo', 'CreateDialog']))
            throw new BadRequestHttpException();

        /** @var yii\base\Model $model */
        $class = "\\matodor\\chat\models\\forms\\$formName";
        $model = new $class();
        $viewName = strtolower(preg_replace('/(?<![A-Z])[A-Z]/', ' \0', $formName));
        $viewName = ltrim(str_replace(' ', '-', $viewName), '-');

        Yii::$app->assetManager->bundles = [
            'yii\bootstrap\BootstrapPluginAsset' => false,
            'yii\bootstrap\BootstrapAsset' => false,
            'yii\web\JqueryAsset' => false,
            'yii\widgets\ActiveFormAsset' => false,
            'yii\validators\ValidationAsset' => false,
            'yii\web\YiiAsset' => false,
        ];

        return $this->renderAjax("forms/$viewName", [
            'model' => $model
        ]);
    }

    public function actionDownloadFile($token)
    {
        $chatUser = $this->chatUser();
        $attachment = ChatAttachment::findOne(['token' => $token]);

        if (is_null($attachment))
            throw new Exception('Bad attachment token');

        return Yii::$app
            ->response
            ->sendFile($attachment->getPath(), $attachment->display_name);
    }

    public function actionUploadFile()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        if (!Yii::$app->request->isPost ||
            !Yii::$app->request->isAjax)
        {
            throw new BadRequestHttpException();
        }

        $chatUser = $this->chatUser();
        $model = new ChatAttachment();
        if ($model->load(Yii::$app->request->post()))
        {
            $model->chat_user_id = $chatUser->id;
            $model->file = UploadedFile::getInstance($model, 'file');

            if ($model->upload())
            {
                return [
                    'success' => true,
                    'attachment' => $model->toArray()
                ];
            }

            return [
                'success' => false,
                'errors' => $model->getErrors()
            ];
        }

        throw new BadRequestHttpException();
    }

    /**
     * @return \matodor\chat\ChatModule
     */
    private function chatModule()
    {
        return Yii::$app->getModule('chat');
    }

    /**
     * @return \matodor\chat\models\ChatUser
     */
    private function chatUser()
    {
        /** @var ChatUser $chatUser */
        $chatModule = $this->chatModule();
        $chatUser = null;

        if (Yii::$app->user->getIsGuest())
        {
            if (Yii::$app->request->cookies->has($chatModule->chatTokenGuestKey))
            {
                $token = Yii::$app->request->cookies->getValue($chatModule->chatTokenGuestKey);
                $chatUser = ChatUser::findOne(['token' => $token]);
            }
        }
        else
        {
            $userId = Yii::$app->user->getIdentity()->getId();
            $chatUser = ChatUser::findOne(['user_id' => $userId]);
        }

        if (is_null($chatUser))
            throw new UnauthorizedHttpException();

        return $chatUser;
    }
}

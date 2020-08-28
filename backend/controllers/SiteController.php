<?php
namespace backend\controllers;

use backend\models\ContactData;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'contact', 'set-emails'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        if (Yii::$app->user->isGuest || !\dektrium\user\models\User::findIdentity(Yii::$app->user->identity->id)->isAdmin) {
            return $this->redirect('login');
        }
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = \Yii::createObject(\dektrium\user\models\LoginForm::class);
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact()
    {
        if (Yii::$app->user->isGuest || !\dektrium\user\models\User::findIdentity(Yii::$app->user->identity->id)->isAdmin) {
            return $this->redirect('login');
        }
        $exist_model = ContactData::find()->one();
        $model = $exist_model ? $exist_model : new ContactData();
        return $this->render('contact', ['model' => $model]);
    }

    public function actionSetEmails($id)
    {
        if (Yii::$app->user->isGuest || !\dektrium\user\models\User::findIdentity(Yii::$app->user->identity->id)->isAdmin) {
            return $this->redirect('login');
        }
        $model = $this->findModel($id);
        $model = $model ? $model : new ContactData();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect('contact');
        }
        return $this->redirect('set-emails');
    }

    protected function findModel($id)
    {
        if (($model = ContactData::findOne($id)) !== null) {
            return $model;
        }

        return false;
    }
}

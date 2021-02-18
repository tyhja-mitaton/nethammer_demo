<?php
namespace backend\controllers;

use backend\models\CaseUpperBlock;
use backend\models\ContactData;
use backend\models\SinglePageSeo;
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
                        'actions' => ['logout', 'index', 'contact', 'set-emails', 'single-seo-main', 'update-seo',
                            'single-seo-products', 'single-seo-services', 'single-seo-cases', 'single-seo-job',
                            'single-seo-reviews', 'single-seo-contacts', 'case-upper-block'],
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

    public function actionCaseUpperBlock()
    {
        if (Yii::$app->user->isGuest || !\dektrium\user\models\User::findIdentity(Yii::$app->user->identity->id)->isAdmin) {
            return $this->redirect('login');
        }
        $exist_model = CaseUpperBlock::find()->one();
        $model = $exist_model ? $exist_model : new CaseUpperBlock();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->render('upper-block', ['model' => $model]);
        }
        return $this->render('upper-block', ['model' => $model]);
    }

    public function actionSingleSeoMain()
    {
        if (Yii::$app->user->isGuest || !\dektrium\user\models\User::findIdentity(Yii::$app->user->identity->id)->isAdmin) {
            return $this->redirect('login');
        }
        $exist_model = SinglePageSeo::find()->where(['type' => SinglePageSeo::MAIN_PAGE_SEO])->one();
        $model = $exist_model ? $exist_model : new SinglePageSeo();
        return $this->render('single-seo', ['model' => $model, 'type' => SinglePageSeo::MAIN_PAGE_SEO]);
    }

    public function actionSingleSeoProducts()
    {
        if (Yii::$app->user->isGuest || !\dektrium\user\models\User::findIdentity(Yii::$app->user->identity->id)->isAdmin) {
            return $this->redirect('login');
        }
        $exist_model = SinglePageSeo::find()->where(['type' => SinglePageSeo::PRODUCTS_PAGE_SEO])->one();
        $model = $exist_model ? $exist_model : new SinglePageSeo();
        return $this->render('single-seo', ['model' => $model, 'type' => SinglePageSeo::PRODUCTS_PAGE_SEO]);
    }

    public function actionSingleSeoServices()
    {
        if (Yii::$app->user->isGuest || !\dektrium\user\models\User::findIdentity(Yii::$app->user->identity->id)->isAdmin) {
            return $this->redirect('login');
        }
        $exist_model = SinglePageSeo::find()->where(['type' => SinglePageSeo::SERVICES_PAGE_SEO])->one();
        $model = $exist_model ? $exist_model : new SinglePageSeo();
        return $this->render('single-seo', ['model' => $model, 'type' => SinglePageSeo::SERVICES_PAGE_SEO]);
    }

    public function actionSingleSeoCases()
    {
        if (Yii::$app->user->isGuest || !\dektrium\user\models\User::findIdentity(Yii::$app->user->identity->id)->isAdmin) {
            return $this->redirect('login');
        }
        $exist_model = SinglePageSeo::find()->where(['type' => SinglePageSeo::CASES_PAGE_SEO])->one();
        $model = $exist_model ? $exist_model : new SinglePageSeo();
        return $this->render('single-seo', ['model' => $model, 'type' => SinglePageSeo::CASES_PAGE_SEO]);
    }

    public function actionSingleSeoJob()
    {
        if (Yii::$app->user->isGuest || !\dektrium\user\models\User::findIdentity(Yii::$app->user->identity->id)->isAdmin) {
        return $this->redirect('login');
        }
        $exist_model = SinglePageSeo::find()->where(['type' => SinglePageSeo::JOB_PAGE_SEO])->one();
        $model = $exist_model ? $exist_model : new SinglePageSeo();
        return $this->render('single-seo', ['model' => $model, 'type' => SinglePageSeo::JOB_PAGE_SEO]);
    }

    public function actionSingleSeoReviews()
    {
        if (Yii::$app->user->isGuest || !\dektrium\user\models\User::findIdentity(Yii::$app->user->identity->id)->isAdmin) {
            return $this->redirect('login');
        }
        $exist_model = SinglePageSeo::find()->where(['type' => SinglePageSeo::REVIEWS_PAGE_SEO])->one();
        $model = $exist_model ? $exist_model : new SinglePageSeo();
        return $this->render('single-seo', ['model' => $model, 'type' => SinglePageSeo::REVIEWS_PAGE_SEO]);
    }

    public function actionSingleSeoContacts()
    {
        if (Yii::$app->user->isGuest || !\dektrium\user\models\User::findIdentity(Yii::$app->user->identity->id)->isAdmin) {
            return $this->redirect('login');
        }
        $exist_model = SinglePageSeo::find()->where(['type' => SinglePageSeo::CONTACT_PAGE_SEO])->one();
        $model = $exist_model ? $exist_model : new SinglePageSeo();
        return $this->render('single-seo', ['model' => $model, 'type' => SinglePageSeo::CONTACT_PAGE_SEO]);
    }

    public function actionUpdateSeo()
    {
        if (Yii::$app->user->isGuest || !\dektrium\user\models\User::findIdentity(Yii::$app->user->identity->id)->isAdmin) {
            return $this->redirect('login');
        }
        $model = SinglePageSeo::findOne(['type' => Yii::$app->request->post()["SinglePageSeo"]["type"]]);
        $model = $model ? $model : new SinglePageSeo();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(SinglePageSeo::getViewPath($model->type));
        }
        return false;
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

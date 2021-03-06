<?php
namespace frontend\controllers;

use backend\models\ContactData;
use backend\models\InfoBlockSearch;
use common\models\ExtraBlock;
use common\models\InfoBlock;
use common\models\Tag;
use frontend\models\Appeal;
use frontend\models\ResendVerificationEmailForm;
use frontend\models\Review;
use frontend\models\VerifyEmailForm;
use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use frontend\models\Sitemap;
use yii\web\Response;
use yii\widgets\ActiveForm;

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
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
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
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    /**
     * @sitemap priority=0.5 changefreq=monthly route=['/site/index'] model=common\models\InfoBlock condition=['type'=>1]
     */
    public function actionIndex()
    {
        $model = InfoBlock::find()->where(['type' => InfoBlock::MAIN_PAGE_SLIDER]);
        $advModel = InfoBlock::find()->where(['type' => InfoBlock::INFO_BLOCK]);
        $extraBlocks = ExtraBlock::find();
        $appeal = new Appeal();
        $provider = new ActiveDataProvider([
            'query' => $model,
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => [
                'defaultOrder' => [
                    'priority' => SORT_DESC,
                ]
            ],
        ]);
        $advProvider = new ActiveDataProvider([
            'query' => $advModel,
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => [
                'defaultOrder' => [
                    'priority' => SORT_DESC,
                ]
            ],
        ]);
        $extraBlocksProvider = new ActiveDataProvider([
            'query' => $extraBlocks,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        return $this->render('index', ['provider' => $provider, 'appeal' => $appeal, 'advProvider' => $advProvider, 'extraBlocksProvider' => $extraBlocksProvider]);
    }

    /**
     * @sitemap priority=0.5 changefreq=monthly route=['/site/job'] model=common\models\InfoBlock condition=['type'=>6]
     */
    public function actionJob()
    {
        $model = InfoBlock::find()->where(['type' => InfoBlock::VACANCY_BLOCK]);
        $provider = new ActiveDataProvider([
            'query' => $model,
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => [
                'defaultOrder' => [
                    'priority' => SORT_DESC,
                ]
            ],
        ]);
        return $this->render('job', ['provider' => $provider]);
    }

    /**
     * @sitemap priority=0.5 changefreq=monthly route=['/site/products'] model=common\models\InfoBlock condition=['type'=>4]
     */
    public function actionProducts()
    {
        $model = InfoBlock::find()->where(['type' => InfoBlock::PRODUCT_BLOCK]);
        $provider = new ActiveDataProvider([
            'query' => $model,
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => [
                'defaultOrder' => [
                    'priority' => SORT_DESC,
                ]
            ],
        ]);
        return $this->render('products', ['provider' => $provider]);
    }

    /**
     * @sitemap priority=0.5 changefreq=monthly route=['/site/product-page','id'=>$model->id] model=common\models\InfoBlock condition=['type'=>4]
     */
    public function actionProductPage($id)
    {
        return $this->render('product-page', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * @sitemap priority=0.5 changefreq=monthly route=['/site/services'] model=common\models\InfoBlock condition=['type'=>3]
     */
    public function actionServices()
    {
        $model = InfoBlock::find()->where(['type' => InfoBlock::SERVICE_BLOCK]);
        $provider = new ActiveDataProvider([
            'query' => $model,
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => [
                'defaultOrder' => [
                    'priority' => SORT_DESC,
                ]
            ],
        ]);
        return $this->render('services', ['provider' => $provider]);
    }

    /**
     * @sitemap priority=0.5 changefreq=monthly route=['/site/service-page','id'=>$model->id] model=common\models\InfoBlock condition=['type'=>3]
     */
    public function actionServicePage($id)
    {
        return $this->render('service-page', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * @sitemap priority=0.5 changefreq=monthly route=['/site/cases'] model=common\models\InfoBlock condition=['type'=>5]
     */
    public function actionCases($tagId = null)
    {
        $tag = null;
        if ($tagId !== null) {
            $tag = Tag::findOne((int) $tagId);
        }

        $model = InfoBlock::find()
            ->andFilterWhere(['type' => InfoBlock::CASE_BLOCK])
            ->andFilterWhere(['tag' => $tagId]);

        $provider = new ActiveDataProvider([
            'query' => $model,
            'sort' => [
                'defaultOrder' => [
                    'priority' => SORT_DESC,
                ]
            ],
        ]);

        $provider->pagination->defaultPageSize = 5;
        $provider->pagination->route = 'site/cases';

        return $this->render('cases', [
            'provider' => $provider,
            'models' => $provider->getModels(),
            'currentTag' => $tag,
        ]);
    }

    /**
     * @sitemap priority=0.5 changefreq=monthly route=['/site/reviews'] model=frontend\models\Review condition=['is_visible'=>1]
     */
    public function actionReviews()
    {
        $model = Review::find()->where(['is_visible' => 1]);
        $provider = new ActiveDataProvider([
            'query' => $model,
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => [
                'defaultOrder' => [
                    'priority' => SORT_DESC,
                ],
            ],
        ]);
        return $this->render('reviews', ['provider' => $provider, 'newModel' => new Review(['scenario' => Review::FRONTEND])]);
    }

    public function actionLeaveReview()
    {
        $model = new Review();
        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->save()) {
            Yii::$app->session->setFlash('success-review', '?????????? ?????????? ?????????????????????? ?????????? ????????????????');
            return $this->redirect(['reviews']);
        } else {
            Yii::$app->session->setFlash('error-review', '???????????? ????????????????.');
            return $this->redirect(['reviews']);
        }

    }

    /**
     * @sitemap priority=0.5
     */
    public function actionSearch()
    {
        $searchModel = new InfoBlockSearch();
        $dataProvider = $searchModel->searchAll();

        return $this->render('search', ['provider' => $dataProvider]);
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = \Yii::createObject(\dektrium\user\models\LoginForm::class);
        if ($model->load(\Yii::$app->request->post()) && $model->login()) {

            return $this->redirect('/user/'.\Yii::$app->user->identity->id);
        } else {
            $model->password = '';
            return $this->render('login', [ 'model'  => $model]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    /**
     * @sitemap priority=0.5 changefreq=monthly route=['/site/contact']
     */
    public function actionContact()
    {
        $model = new Appeal();
        $contactData = ContactData::findOne(1);
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $emails = $contactData ? $contactData->getEmailsArray() : Yii::$app->params['adminEmails'];
            if ($model->sendEmail($emails, $contactData, $model)) {
                Yii::$app->session->setFlash('success', '?????????????????? ????????????????????. ?? ?????????????????? ?????????? ?? ???????? ???????????????? ?????? ????????????????.');
            } else {
                Yii::$app->session->setFlash('error', '?????? ???????????????? ?????????????????? ???????????????? ????????????');
            }

            return $this->refresh();
        } else {
            return $this->render('contacts', [
                'model' => $model,
            ]);
        }
    }

    public function actionValidateContactForm()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        if (Yii::$app->request->isAjax) {
            $model = new Appeal();

            if ($model->load(Yii::$app->request->post())) {
                return ActiveForm::validate($model);
            }
        }

        throw new BadRequestHttpException();
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', 'Thank you for registration. Please check your inbox for verification email.');
            return $this->goHome();
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * Verify email address
     *
     * @param string $token
     * @throws BadRequestHttpException
     * @return yii\web\Response
     */
    public function actionVerifyEmail($token)
    {
        try {
            $model = new VerifyEmailForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if ($user = $model->verifyEmail()) {
            if (Yii::$app->user->login($user)) {
                Yii::$app->session->setFlash('success', 'Your email has been confirmed!');
                return $this->goHome();
            }
        }

        Yii::$app->session->setFlash('error', 'Sorry, we are unable to verify your account with provided token.');
        return $this->goHome();
    }

    /**
     * Resend verification email
     *
     * @return mixed
     */
    public function actionResendVerificationEmail()
    {
        $model = new ResendVerificationEmailForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
                return $this->goHome();
            }
            Yii::$app->session->setFlash('error', 'Sorry, we are unable to resend verification email for the provided email address.');
        }

        return $this->render('resendVerificationEmail', [
            'model' => $model
        ]);
    }

    //?????????? ??????????. ?????????????? ?? ???????? XML ??????????.
    public function actionSitemap(){
        $sitemap = new Sitemap();
        //???????? ?? ???????? ?????? ?????????? ??????????
        if (!$xml_sitemap = Yii::$app->cache->get('sitemap')) {
            //???????????????? ???????????? ???????? ????????????
            $urls = $sitemap->getUrl();
            //?????????????????? XML ????????
            $xml_sitemap = $sitemap->getXml($urls);
            // ???????????????? ??????????????????
            Yii::$app->cache->set('sitemap', $xml_sitemap, 3600*12);
        }
        //?????????????? ?????????? ??????????
        $sitemap->showXml($xml_sitemap);
    }

    public function actionConfPolicy()
    {
        $confidPolModel = \backend\models\ConfidPol::find()->one();

        return $this->render('conf-policy', ['confidPolModel' => $confidPolModel]);
    }

    /**
     * Finds the InfoBlock model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return InfoBlock the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = InfoBlock::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

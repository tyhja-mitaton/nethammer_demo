<?php
/* @var $model \frontend\models\Appeal */

use backend\models\ContactData;
use backend\models\SinglePageSeo;
use yii\bootstrap4\Breadcrumbs;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Контакты';
$this->params['breadcrumbs'][] = $this->title;

$this->registerMetaTag([
    'name' => 'og:url',
    'content' => Url::base(true).Url::current(),
]);

$contactDataModel = ContactData::find()->one();
$mainSeo = SinglePageSeo::findOne(['type' => SinglePageSeo::CONTACT_PAGE_SEO]);
if($mainSeo) {
    $this->registerMetaTag([
        'name' => 'og:title',
        'content' => $mainSeo->seo->title,
    ]);
    $this->registerMetaTag([
        'name' => 'og:description',
        'content' => $mainSeo->seo->description,
    ]);

    $this->registerMetaTag([
        'name' => 'keywords',
        'content' => $mainSeo->seo->keywords,
    ]);
}
?>
<div class="contact-page">
    <div class="container">
        <h1 class="page-title"><?= Html::encode($this->title) ?></h1>
        <nav>
            <?= Breadcrumbs::widget([
                'tag' => 'ol',
                'itemTemplate' => '<li class="breadcrumb-item">{link}</li>',
                'activeItemTemplate' => '<li class="breadcrumb-item active">{link}</li>',
                'homeLink' => ['label' => 'Главная', 'url' => '/'],
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
        </nav>
    </div>
    <div class="container">
    <div class="row">
        <div class="col-lg-5 pl-5 order-lg-1">
            <div class="label">
                <i class="fas fa-map-marker-alt"></i> Адрес:
            </div>
            <p><?=isset($contactDataModel->address) ? $contactDataModel->address : Yii::$app->params['address']?></p>
            <div class="label">
                <i class="fas fa-phone-alt"></i> Телефон:
            </div>
            <p><a class="contact-phone" href="tel:<?=isset($contactDataModel->phone) ? $contactDataModel->phone : Yii::$app->params['phone']?>">
                    <?=isset($contactDataModel->phone) ? $contactDataModel->phone : Yii::$app->params['phone']?>
                </a></p>
            <div class="label">
                <img src="" alt=""> Соц сети:
            </div>
            <ul class="social">
                <li><a href="<?=isset($contactDataModel->vk_link) ? $contactDataModel->vk_link : '#'?>"><i class="fab fa-vk"></i></a></li>
                <li><a href="<?=isset($contactDataModel->fb_link) ? $contactDataModel->fb_link : '#'?>"><i class="fab fa-facebook-f"></i></a></li>
                <li><a href="<?=isset($contactDataModel->twitter_link) ? $contactDataModel->twitter_link : '#'?>"><i class="fab fa-twitter"></i></a></li>
            </ul>
        </div>
        <div class="col-lg-7">
            <div class="map">
                <script type="text/javascript" charset="utf-8" async src="<?=isset($contactDataModel->map_link) ? $contactDataModel->map_link : ''?>"></script>
            </div>
        </div>
    </div>
    </div>
    <?= $this->render('_contact', ['model' => $model]); ?>
</div>
<?php
$this->title = 'Контакты';
?>
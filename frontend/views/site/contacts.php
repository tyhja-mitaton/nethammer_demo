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
        <?php if( Yii::$app->session->hasFlash('success') ): ?>
            <div class="alert alert-success alert-dismissible" role="alert">
                <?php echo Yii::$app->session->getFlash('success'); ?>
            </div>
        <?php endif;?>
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
                <?php foreach ([
                    [$contactDataModel->vk_link, 'fab fa-vk'],
                    [$contactDataModel->fb_link, 'fab fa-facebook-f'],
                    [$contactDataModel->twitter_link, 'fab fa-twitter'],
                    [$contactDataModel->tg_link, 'fab fa-telegram'],
                ] as $item) { ?>
                    <?php if ($item[0] !== null && $item[0] !== '') { ?>
                        <li>
                            <a href="<?= $item[0] ?>" target="_blank">
                                <i class="<?= $item[1] ?>"></i>
                            </a>
                        </li>
                    <?php } ?>
                <?php } ?>
            </ul>
        </div>

        <div class="col-lg-7">
            <?php if (isset($contactDataModel->map_link)) { ?>
                <div class="map">
                    <?= $contactDataModel->map_link ?>
                </div>
            <?php } ?>
        </div>
    </div>
    </div>
    <?= $this->render('_contact', ['model' => $model]); ?>
</div>
<?php
$this->title = 'Контакты';
?>

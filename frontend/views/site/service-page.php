<?php
/**
 * @var $model common\models\InfoBlock
 */
use yii\bootstrap4\Breadcrumbs;
use yii\helpers\Html;
use yii\helpers\Url;

if(!$title = $model->seo->title) {
    $title = $model->title;
}

if(!$description = $model->seo->description) {
    $description = $model->description;
}

if(!$keywords = $model->seo->keywords) {
    $keywords = '';
}

$this->title = $title;
$this->params['breadcrumbs'][] = ['label' => 'Услуги', 'url' => Url::toRoute('/services/')];
$this->params['breadcrumbs'][] = $model->title;

$this->registerMetaTag([
    'name' => 'og:title',
    'content' => $title,
]);
$this->registerMetaTag([
    'name' => 'og:description',
    'content' => $description,
]);

$this->registerMetaTag([
    'name' => 'keywords',
    'content' => $keywords,
]);
$this->registerMetaTag([
    'name' => 'og:url',
    'content' => Url::base(true).Url::current(),
]);

$avatar = floor12\files\models\File::find()->where(['object_id' => $model->id, 'field' => 'avatar'])->one();
$workProcess = \frontend\models\WorkProcess::findOne(['service_id' => $model->id]);
$servicePrice = \frontend\models\ServicePrice::findOne(['service_id' => $model->id]);
 ?>

<div class="service-page">
    <div class="container">
        <h1 class="page-title"><?= Html::encode($model->title) ?></h1>
        <nav>
            <?= Breadcrumbs::widget([
                'tag' => 'ol',
                'itemTemplate' => '<li class="breadcrumb-item">{link}</li>',
                'activeItemTemplate' => '<li class="breadcrumb-item active">{link}</li>',
                'homeLink' => ['label' => 'Главная', 'url' => '/'],
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
        </nav>
    <!--</div>-->
    <div class="row mb-5 align-items-center">
        <div class="col-lg-6 order-lg-1 mb-4 text-center">
            <img src="<?=isset($avatar->href) ? $avatar->href : '' ?>" alt="<?=isset($avatar->title) ? $avatar->title : ''?>">
        </div>
        <div class="col-lg-6">
            <?=$model->description ?>
        </div>
    </div>
        <?php if ($workProcess !== null) { ?>
    <div class="row">
        <div class="col-lg-6 offset-lg-4">
            <p class="h2"><?=$workProcess->title?></p>
        </div>
    </div>

    <div class="row mb-5">
        <div class="col-lg-4">
            <div class="how-box">
                <img src="images/time.png" alt="">
                <span><?=$workProcess->block1_text?></span>
            </div>
            <div class="how-box">
                <img src="images/diamond.png" alt="">
                <span><?=$workProcess->block2_text?></span>
            </div>
        </div>
        <div class="col-lg-8 pt-lg-4">
            <?=$workProcess->text?>
        </div>
    </div>
<?php }
if ($servicePrice !== null) {?>
    <div class="row">
        <div class="col-lg-7">
            <p class="h2"><?=$servicePrice->title?></p>
            <p><?=$servicePrice->text?></p>
        </div>
    </div>
        <?php } ?>
    </div>
</div>
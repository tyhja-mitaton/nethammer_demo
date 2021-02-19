<?php

/** @var \yii\data\ActiveDataProvider $provider */
/** @var \yii\web\View $this */

use backend\models\SinglePageSeo;
use yii\bootstrap4\Breadcrumbs;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title = 'Кейсы';
$this->params['breadcrumbs'][] = $this->title;

$this->registerMetaTag([
    'name' => 'og:url',
    'content' => Url::base(true).Url::current(),
]);

/** @var \common\models\InfoBlock[] $models */
$models = $provider->getModels();
$mainSeo = SinglePageSeo::findOne(['type' => SinglePageSeo::CASES_PAGE_SEO]);

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

$tags = \common\models\InfoBlock::getTags();
$caseUpperBlock = \backend\models\CaseUpperBlock::find()->one();
$this->registerJsFile('/js/scripts_cases.js', ['depends' => [\frontend\assets\SlickSliderAssets::class]]);

?>

<div class="cases-page">
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

    <div class="cases-filter-box" style="padding-bottom: 10px; <?=(isset($caseUpperBlock->text) && $caseUpperBlock->text != '') ? 'padding-top: 10px;' : ''?>">
        <?php if(isset($caseUpperBlock->text) && $caseUpperBlock->text != ''):?>
            <div class="container case-upper-block"><?=$caseUpperBlock->text?></div>
        <?php endif;?>
        <div class="container">
            <div class="cases-filter">
                <?php foreach ($tags as $key => $tag){ ?>
                    <input type="checkbox" id="ch<?=$key?>" hidden checked>
                    <label for="ch<?=$key?>"><?=$tag?></label>
                <?php }?>
            </div>
        </div>
    </div>

    <div class="cases-list">
        <?php foreach ($models as $model) { ?>
            <?php $imgModels = floor12\files\models\File::find()->where(['object_id' => $model->id, 'field' => 'imgs'])->all(); ?>
            <div class="case" data-tag="<?= $model->tag ?>">
                <div class="container">
                    <p class="title"><?=$model->title ?></p>
                </div>

                <div class="case-slider">
                    <?php foreach ($imgModels as $img) { ?>
                        <div class="item">
                            <a class="item__img-wrapper" data-fancybox-id="cases-gallery-<?=$model->id?>" href="<?=$img->href?>" title="<?=$img->title?>" data-type="image">
                                <?= Html::img($img->href); ?>
                            </a>
                        </div>
                    <?php } ?>

                </div>

                <div class="case-slider__fake-dots">
                    <ul class="slick-dots" style="" role="tablist">
                        <li class="slick-active" role="presentation">
                            <button type="button" role="tab" aria-controls="slick-slide00" tabindex="0" aria-selected="true">1</button>
                        </li>
                    </ul>
                </div>

                <div class="case-text">
                    <p><b>О проекте</b></p>
                    <p><?=$model->intro ?></p>
                    <br>
                    <p><?=$model->description ?></p>
                </div>

                <p class="case-more">
                    <a href="#">
                        <span><?=$model->btn_name?></span>
                        <span style="display:none;">Свернуть</span>
                    </a>
                </p>
            </div>
        <?php } ?>
    </div>

    <div class="bg-white py-4">
        <?= LinkPager::widget(ArrayHelper::merge(Yii::$app->params['pagerParams'], [
            'pagination' => $provider->pagination,
            'hideOnSinglePage' => false,
            'view' => $this,
        ])); ?>
    </div>
</div>

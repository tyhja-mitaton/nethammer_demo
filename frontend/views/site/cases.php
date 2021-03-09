<?php

use backend\models\SinglePageSeo;
use common\models\InfoBlock;
use common\models\Tag;
use yii\bootstrap4\Breadcrumbs;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Inflector;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\LinkPager;

/** @var ActiveDataProvider $provider */
/** @var View $this */
/** @var InfoBlock[] $models */
/** @var Tag $currentTag */

$this->title = 'Кейсы';
$this->params['breadcrumbs'][] = $this->title;

$this->registerMetaTag([
    'name' => 'og:url',
    'content' => Url::base(true).Url::current(),
]);

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

$tags = InfoBlock::getTags(InfoBlock::CASE_BLOCK)                                          ;
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
            <div class="cases-filter d-flex flex-wrap m-n1">
                <?= Html::a('Все кейсы', ['site/cases'], [
                    'class' => 'm-1 cases-filter__btn' . ($currentTag === null
                        ? ' cases-filter__btn_selected'
                        : null
                    ),
                ]) ?>

                <?php foreach ($tags as $tagId => $tag) { ?>
                    <?= Html::a($tag, ['site/cases', 'tagId' => $tagId, 'tag' => Inflector::slug($tag)], [
                        'class' => 'm-1 cases-filter__btn' . ($currentTag && $currentTag->id == $tagId
                            ? ' cases-filter__btn_selected'
                            : ''
                        ),
                    ]) ?>
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
                    <?php $imgIndex = 0; ?>
                    <?php foreach ($imgModels as $img) { ?>
                        <div class="item">
                            <a class="item__img-wrapper"
                                href="javascript:;"
                                title="<?= $img->title ?>"
                                data-index="<?= $imgIndex++ ?>"
                                data-src="<?= $img->href ?>"
                            >
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

                <p class="case-more mt-2">
                    <a href="#" class="case-more__link">
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

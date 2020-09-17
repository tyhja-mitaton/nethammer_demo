<?php
/**
 * @var $provider yii\data\ActiveDataProvider
 */

use backend\models\SinglePageSeo;
use yii\bootstrap4\Breadcrumbs;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Кейсы';
$this->params['breadcrumbs'][] = $this->title;

$this->registerMetaTag([
    'name' => 'og:url',
    'content' => Url::base(true).Url::current(),
]);

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
    <div class="cases-filter-box">
        <div class="container">
            <div class="cases-filter">
                <input type="checkbox" id="ch1" hidden checked>
                <label for="ch1">Design</label>
                <input type="checkbox" id="ch2" hidden>
                <label for="ch2">Photography</label>
                <input type="checkbox" id="ch3" hidden>
                <label for="ch3">Digital Arts</label>
            </div>
        </div>
    </div>

    <div class="cases-list">
        <?php foreach ($models as $model) {
            $imgModels = floor12\files\models\File::find()->where(['object_id' => $model->id, 'field' => 'imgs'])->all();?>
        <div class="case">
            <div class="container">
                <p class="title"><?=$model->title ?></p>
            </div>
            <div class="case-slider owl-carousel owl-theme">
                <?php foreach ($imgModels as $img) { ?>
                    <div class="item">
                        <?=Html::img($img->href); ?>
                    </div>
                <?php } ?>
            </div>
            <div class="case-text">
                <p><b>О проекте</b></p>
                <p><?=$model->description ?></p>
            </div>
        </div>
        <?php } ?>
    </div>
</div>
<?php
$js = <<<JS
$(document).ready(function(){
  $('.owl-carousel').owlCarousel({responsive:{768:{items: 3}, 320:{items: 1}}});
  /*$('[data-fancybox="products-gallery"]').fancybox({
	parentEl:"div"
});*/
});
JS;
$this->registerJs($js);
?>
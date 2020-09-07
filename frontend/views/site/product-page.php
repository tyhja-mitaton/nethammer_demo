<?php
/**
 * @var $model common\models\InfoBlock
 */

use yii\bootstrap4\Breadcrumbs;
use yii\helpers\Html;
use yii\bootstrap4\Modal;
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
$this->params['breadcrumbs'][] = $this->title;

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

$imgModels = floor12\files\models\File::find()->where(['object_id' => $model->id, 'field' => 'imgs'])->all();
$firstImg = floor12\files\models\File::find()->where(['object_id' => $model->id, 'field' => 'imgs'])->one();
$appealModel = new \frontend\models\Appeal();
?>
<div class="product-page">
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
    <div class="content">
        <div class="container">
            <div class="product-top">
                <h2 class="subtitle"><?=$model->title ?></h2>
                <div class="text"><?=$model->description ?></div>
                <img class="main-img" src="<?=isset($firstImg->href) ? $firstImg->href: ''?>" alt="">
            </div>

            <div class="product-slider owl-carousel owl-theme">
                <?php foreach ($imgModels as $img) { ?>
                    <a class="img" href="<?=$img->href?>" data-fancybox="products-gallery" title="<?=$img->title?>" data-hash="<?=$img->hash?>">
                        <?=Html::img($img->href); ?>
                    </a>
                <?php } ?>
            </div>

            <?php Modal::begin([
                'title' => '',
                'toggleButton' => ['label' => 'Оставить заявку <i>→</i>', 'class' => 'btn btn-blue-o'],
                'footer' => '',
                'size' => Modal::SIZE_EXTRA_LARGE,
            ]);

            echo $this->render('_contact', ['model' => $appealModel]);

            Modal::end();?>
        </div>
    </div>
</div>
<?php
$js = <<<JS
$(document).ready(function(){
  $('.owl-carousel').owlCarousel({responsive:{768:{items: 3}, 320:{items: 2}}});
  $('[data-fancybox="products-gallery"]').fancybox({
	//iframe:{css: {'max-width' : '1344px', width: '40%'}},
	afterLoad: function () {
            $('.fancybox-content').width(parseInt($('.fancybox-iframe').contents().find('html img').width()));
            $('.fancybox-content').height(parseInt($('.fancybox-iframe').contents().find('html img').height()));
    }
});
});
JS;
$this->registerJs($js);
?>

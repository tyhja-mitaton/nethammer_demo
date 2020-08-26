<?php
/**
 * @var $model common\models\InfoBlock
 */
use yii\helpers\Html;

$this->title = 'Страница продукта';
$this->params['breadcrumbs'][] = $this->title;
$imgModels = floor12\files\models\File::find()->where(['object_id' => $model->id, 'field' => 'imgs'])->all();
$firstImg = floor12\files\models\File::find()->where(['object_id' => $model->id, 'field' => 'imgs'])->one();
?>
<div class="product-page">
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

            <button class="btn btn-blue-o" type="button">
                Оставить заявку <i>→</i>
            </button>
        </div>
    </div>
</div>
<?php
$js = <<<JS
$(document).ready(function(){
  $('.owl-carousel').owlCarousel({responsive:{768:{items: 3}}});
  /*$('[data-fancybox="products-gallery"]').fancybox({
	parentEl:"div"
});*/
});
JS;
$this->registerJs($js);
?>

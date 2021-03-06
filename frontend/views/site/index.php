<?php
/**
 * @var $this yii\web\View
 * @var $provider yii\data\ActiveDataProvider
 * @var $appeal frontend\models\Appeal
 * @var $advProvider yii\data\ActiveDataProvider
 * @var $extraBlocksProvider yii\data\ActiveDataProvider
 */

use floor12\files\models\File;
use yii\helpers\Html;
use yii\helpers\Url;
use backend\models\SinglePageSeo;


$this->registerMetaTag([
    'name' => 'og:url',
    'content' => Url::home(true),
]);

$models = $provider->getModels();
$advModels = $advProvider->getModels();
$extraBlocks = $extraBlocksProvider->getModels();
$mainSeo = SinglePageSeo::findOne(['type' => SinglePageSeo::MAIN_PAGE_SEO]);
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
<div class="home-page">
    <div class="container">
        <div class="home-slider owl-carousel owl-theme">
        <?php foreach ($models as $model) {
            $avatar = floor12\files\models\File::find()->where(['object_id' => $model->id, 'field' => 'avatar'])->one();?>
            <div class="item">
                <div class="row align-items-center">
                    <div class="col-md-6 order-md-1">
                        <img src="<?=isset($avatar->href) ? $avatar->href : '' ?>" alt="">
                    </div>
                    <div class="col-md-6">
                        <p class="title"><?=$model->title ?></p>
                        <p><?=$model->description ?></p>
                        <a class="btn btn-white" href="<?=$model->btn_name ?>">
                            Подробнее <i>→</i>
                        </a>
                    </div>
                </div>
            </div>
        <?php } ?>
        </div>

        <div class="row align-items-center">
            <div class="col-md-6">
                <ul class="nav nav-tabs">
                    <?php $i=0; foreach ($advModels as $model) { $i++;
                        $avatar = floor12\files\models\File::find()->where(['object_id' => $model->id, 'field' => 'avatar'])->one();
                        $descriptShort = \yii\helpers\StringHelper::truncateWords($model->description, 6, '', true);
                        ?>
                    <li class="nav-item">
                        <a class="nav-link <?= $i === 1 ? 'active' : ''?>" data-toggle="tab" href="#tab<?=$i?>">
                            <img src="<?=isset($avatar->href) ? $avatar->href : '' ?>" alt="" style="max-width:50px;max-height:50px;">
                            <span><b><?=$model->btn_name ?></b> <span><?= $descriptShort; ?></span></span>
                        </a>
                    </li>
                    <?php } ?>
                </ul>
            </div>
            <div class="col-md-6">
                <div class="tab-content">
                <?php $i=0; foreach ($advModels as $model) { $i++;?>
                    <div class="tab-pane fade show <?= $i === 1 ? 'active' : ''?>" id="tab<?=$i?>">
                        <p class="tab-title"><?=$model->title?></p>
                        <p><?=$model->description?></p>
                    </div>
                <?php } ?>
                </div>
            </div>
        </div>
        <?php foreach($extraBlocks as $extraBlock){
            $img = File::find()->where(['object_id' => $extraBlock->id, 'field' => 'img'])->one();?>
        <div class="row extra-block">
            <h2 class="title"><?=$extraBlock->title?></h2>
            <img class="img" src="<?=isset($img->href) ? $img->href : '' ?>" alt="<?=isset($img->title) ? $img->title : '' ?>">
            <div class="desc"><?=$extraBlock->text ?></div>
            <?=Html::a("$extraBlock->btn_name <i>→</i>",$extraBlock->btn_link, ['class' => 'btn btn-blue-o'])?>
        </div>
        <?php }?>
    </div>
    <?= $this->render('_contact', ['model' => $appeal]);?>
</div>
<?php
$this->title = 'Nethammer';
$js = <<<JS
$(document).ready(function(){
  $('.owl-carousel').owlCarousel({responsive:{768:{items: 1}, 320:{items: 1}}, loop:true, autoplay:true, autoplayTimeout:10000});
  $('.owl-carousel').trigger('play.owl.autoplay',[10000]);
});
JS;
$this->registerJs($js);
?>
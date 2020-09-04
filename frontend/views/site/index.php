<?php
/**
 * @var $this yii\web\View
 * @var $provider yii\data\ActiveDataProvider
 * @var $appeal frontend\models\Appeal
 * @var $advProvider yii\data\ActiveDataProvider
 */
use yii\helpers\Url;

$this->title = 'Nethammer';

$this->registerMetaTag([
    'name' => 'og:url',
    'content' => Url::home(true),
]);

$models = $provider->getModels();
$advModels = $advProvider->getModels();
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
                            <img src="<?=isset($avatar->href) ? $avatar->href : '' ?>" alt="">
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
    </div>
    <?= $this->render('_contact', ['model' => $appeal]);?>
</div>
<?php
$js = <<<JS
$(document).ready(function(){
  $('.owl-carousel').owlCarousel({responsive:{768:{items: 1}, 320:{items: 1}}});
});
JS;
$this->registerJs($js);
?>
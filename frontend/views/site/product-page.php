<?php
/**
 * @var $model common\models\InfoBlock
 */

$this->title = 'Страница продукта';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="product-page">
    <div class="content">
        <div class="container">
            <div class="product-top">
                <h2 class="subtitle"><?=$model->title ?></h2>
                <div class="text"><?=$model->description ?></div>
                <img class="main-img" src="images/screen.jpg" alt="">
            </div>

            <div class="product-slider">
                <?php for($i = 0; $i < 12; $i++) { ?>
                    <a class="img" href="images/screen.jpg">
                        <img data-fancybox="gallery" src="images/screen.jpg" alt="">
                    </a>
                <?php } ?>
            </div>

            <button class="btn btn-blue-o" type="button">
                Оставить заявку <i>→</i>
            </button>
            <?=\floor12\files\components\FileListWidget::widget([
                'files' => floor12\files\models\File::find()->where(['object_id' => $model->id])->all(),
                'downloadAll' => true,
                'zipTitle' => "Documents of {$this->title}"
            ])  ?>
        </div>
    </div>
</div>

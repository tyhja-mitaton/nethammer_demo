<?php
/**
 * @var $provider yii\data\ActiveDataProvider
 */
$this->title = 'Отзывы';
$this->params['breadcrumbs'][] = $this->title;

$models = $provider->getModels();
?>
<div class="reviews-page">
    <div class="container">
        <button class="btn btn-blue-o" type="button" data-toggle="modal" data-target="#modal">Оставить отзыв</button>
    </div>

    <div class="container-fluid">
        <div class="reviews-slider">
            <?php foreach ($models as $model) { ?>
                <div class="item">
                    <div class="d-flex align-items-center">
                        <img src="images/review.png" alt="">
                        <div class="name">
                            <?=$model->author ?>
                            <div><?=$model->date ?></div>
                        </div>
                    </div>
                    <div class="text"><?=$model->text ?></div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

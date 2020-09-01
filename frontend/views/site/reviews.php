<?php
/**
 * @var $provider yii\data\ActiveDataProvider
 */
$this->title = 'Отзывы';
$this->params['breadcrumbs'][] = $this->title;

$models = $provider->getModels();

use yii\bootstrap4\Breadcrumbs;
use yii\helpers\Html; ?>
<div class="reviews-page">
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

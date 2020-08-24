<?php
/**
 * @var $provider yii\data\ActiveDataProvider
 */

use yii\helpers\Html;

$this->title = 'Услуги';
$this->params['breadcrumbs'][] = $this->title;

$models = $provider->getModels();
?>
<div class="category-page">
    <section class="category-list">
        <?php $i = 0; foreach ($models as $model) { $i++; ?>
        <div class="item">
            <div class="container">
                <h2 class="title"><?=$model->title ?></h2>
                <img class="img" src="images/service<?=$i ?>.png" alt="">
                <div class="desc"><?=$model->description ?></div>
                <?= Html::a('Подробнее <i>→</i>', ['service-page', 'id' => $model->id], ['class' => 'btn btn-blue-o']) ?>
            </div>
        </div>
        <?php } ?>
    </section>
</div>

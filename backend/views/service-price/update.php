<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\ServicePrice */

$this->title = 'Обновить расценку услуг: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Расценки услуг', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Обновить';
?>
<div class="service-price-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

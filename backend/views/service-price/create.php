<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\ServicePrice */

$this->title = 'Создать расценку услуг';
$this->params['breadcrumbs'][] = ['label' => 'Расценки услуг', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="service-price-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

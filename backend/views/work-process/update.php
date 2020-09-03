<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\WorkProcess */

$this->title = 'Обновить рабочий процесс: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Рабочие процессы', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Обновить';
?>
<div class="work-process-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

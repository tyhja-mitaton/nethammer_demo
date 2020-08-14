<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\InfoBlock */

$this->title = 'Update Info Block: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Info Blocks', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="info-block-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\InfoBlock */

$this->title = 'Создать информационный блок';
$this->params['breadcrumbs'][] = ['label' => 'Информационные блоки', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="info-block-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

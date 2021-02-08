<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ExtraBlock */

$this->title = 'Создать дополнительный блок';
$this->params['breadcrumbs'][] = ['label' => 'Дополнительные блоки', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="extra-block-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

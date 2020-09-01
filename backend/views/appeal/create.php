<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Appeal */

$this->title = 'Создать обращение';
$this->params['breadcrumbs'][] = ['label' => 'Обращения', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="appeal-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

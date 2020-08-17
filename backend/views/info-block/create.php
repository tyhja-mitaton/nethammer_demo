<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\InfoBlock */
/* @var $imgFiles backend\models\UploadImage */

$this->title = 'Create Info Block';
$this->params['breadcrumbs'][] = ['label' => 'Info Blocks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="info-block-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'imgFiles' => $imgFiles
    ]) ?>

</div>
<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\InfoBlock */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Информационные блоки', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

$sliderType = \common\models\InfoBlock::MAIN_PAGE_SLIDER;
$infoType = \common\models\InfoBlock::INFO_BLOCK;
$serviceType = \common\models\InfoBlock::SERVICE_BLOCK;
$productType = \common\models\InfoBlock::PRODUCT_BLOCK;
$caseType = \common\models\InfoBlock::CASE_BLOCK;
$jobType = \common\models\InfoBlock::VACANCY_BLOCK;
?>
<div class="info-block-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Обновить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить этот элемент?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
<?php
$viewFieldsArr = [
    'model' => $model,
    'attributes' => [
        'id',
        'title',
        'description:ntext',
        'btn_name',
        'type',
        /*'salary',
        'imgs',*/
    ],
];
switch ($model->type) {
    case $jobType: $viewFieldsArr['attributes'][] = 'salary'; break;
}
?>
    <?= DetailView::widget($viewFieldsArr) ?>

</div>

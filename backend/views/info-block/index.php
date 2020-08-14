<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\InfoBlockSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Info Blocks';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="info-block-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Info Block', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
            'description:ntext',
            'btn_name',
            'type',
            //'imgs',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>

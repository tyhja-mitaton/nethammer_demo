<?php

use floor12\files\components\FileInputWidget;
use floor12\files\models\File;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Review */
/* @var $form yii\widgets\ActiveForm */

$logo = File::find()->where(['object_id' => $model->id, 'field' => 'logo'])->one();
$model->__set('logo', $logo);
?>

<div class="review-form">

    <?php $form = ActiveForm::begin();?>

    <?= $form->field($model, 'author')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'text')->textarea(['rows' => 6]) ?>
    <?= $form->field($model, 'dateTime')->widget(\yii\jui\DatePicker::class,['language' => 'ru', 'dateFormat' => 'php:d.m.Y']) ?>
    <?= $form->field($model, 'logo')->widget(FileInputWidget::class)?>

    <?= $form->field($model, 'is_visible')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\tinymce\TinyMce;
use backend\models\UploadImage;

/* @var $this yii\web\View */
/* @var $model common\models\InfoBlock */
/* @var $form yii\widgets\ActiveForm */
/* @var $imgFiles backend\models\UploadImage */
?>

<div class="info-block-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->widget(TinyMce::class, [
        'language' => 'ru',
        'clientOptions' => [
            'plugins' => 'paste',
            'paste_as_text' => true,
        ]
    ]) ?>

    <?= $form->field($model, 'btn_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'type')->dropDownList([
            '1' => 'слайдер на главной странице',
        '2' => 'информационный блок с преимуществами на главной',
        '3' => 'блок с услугой на странице "Услуги"',
        '4' => 'блок на странице "Кейсы"',
        '5' => 'вакансия на странице "Вакансии"'
    ], ['prompt' => 'Выберите тип...']) ?>

    <?= $form->field($imgFiles, 'imageFiles[]')->fileInput(['multiple' => true])?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

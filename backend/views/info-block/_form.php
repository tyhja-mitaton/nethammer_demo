<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\tinymce\TinyMce;

/* @var $this yii\web\View */
/* @var $model common\models\InfoBlock */
/* @var $form yii\widgets\ActiveForm */
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
        '4' => 'блок с продуктом на странице "Продукты"',
        '5' => 'блок на странице "Кейсы"',
        '6' => 'вакансия на странице "Вакансии"'
    ], ['prompt' => 'Выберите тип...']) ?>

    <?= $form->field($model, 'imgs')->widget(floor12\files\components\FileInputWidget::class)?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

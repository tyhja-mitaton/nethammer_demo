<?php

use dosamigos\tinymce\TinyMce;
use floor12\files\components\FileInputWidget;
use floor12\files\models\File;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ExtraBlock */
/* @var $form yii\widgets\ActiveForm */

$img = File::find()->where(['object_id' => $model->id, 'field' => 'img'])->one();
$model->__set('img', $img);
?>

<div class="extra-block-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'text')->widget(TinyMce::class, [
        'language' => 'ru',
        'clientOptions' => [
            'plugins' => 'paste,link',
            'paste_as_text' => true,
        ]
    ]) ?>

    <?= $form->field($model, 'btn_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'btn_link')->textInput(['maxlength' => true]) ?>

     <?= $form->field($model, 'img')->widget(FileInputWidget::class) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

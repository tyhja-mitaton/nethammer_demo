<?php

use dosamigos\tinymce\TinyMce;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\InfoBlock;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model frontend\models\WorkProcess */
/* @var $form yii\widgets\ActiveForm */

$services = InfoBlock::find()->where(['type' => InfoBlock::SERVICE_BLOCK])->all();
?>

<div class="work-process-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'text')->widget(TinyMce::class, [
        'language' => 'ru',
        'clientOptions' => [
            'plugins' => 'paste',
            'paste_as_text' => true,
        ]
    ]) ?>

    <?= $form->field($model, 'block1_text')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'block2_text')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'service_id')->dropDownList(ArrayHelper::map($services, 'id', 'title')) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

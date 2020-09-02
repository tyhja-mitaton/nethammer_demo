<?php
/* @var $model backend\models\ContactData */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title = 'Параметры контактной формы';
$id_param = isset($model->id) ? $model->id : 1;
?>
<div><span>Получатели: </span><?=$model->emails?></div>
<?php $form = ActiveForm::begin(['action' => 'set-emails?id='.$id_param, 'errorCssClass' => 'error']); ?>
<?= $form->field($model, 'subject')->textInput(['maxlength' => true]) ?>
<?= $form->field($model, 'emails')->textInput(['maxlength' => true, 'placeholder' => 'Адреса (через пробел)']) ?>
<?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>
<?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>
<?= $form->field($model, 'vk_link')->textInput(['maxlength' => true]) ?>
<?= $form->field($model, 'fb_link')->textInput(['maxlength' => true]) ?>
<?= $form->field($model, 'twitter_link')->textInput(['maxlength' => true]) ?>
<?= $form->field($model, 'map_link')->textInput(['maxlength' => true, 'placeholder' => 'src="ссылка"']) ?>
<?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
<?php ActiveForm::end(); ?>


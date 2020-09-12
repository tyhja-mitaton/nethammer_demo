<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var matodor\chat\models\forms\SetInfo $model */

?>

<div class="setinfo-block-container">
    <div class="dialogs-container__close"></div>
    <?php $form = ActiveForm::begin([
        'options' => [
            'class' => 'setinfo-block',
            'id' => 'setinfo-form_' . time()
        ]
    ]); ?>
        <div class="setinfo-block__header">
            <?= Yii::t('matodor.chat', 'chat.setinfo.header') ?>
        </div>
        <div class="setinfo-block__input-group">
            <?= $form->field($model, 'firstName')->textInput([
                'placeholder' => $model->getAttributeLabel('firstName'),
                'class' => 'w-100 form-control setinfo-block__input',
                'maxlength' => 32
            ])->label(false) ?>

            <?= $form->field($model, 'lastName')->textInput([
                'placeholder' => $model->getAttributeLabel('lastName'),
                'class' => 'w-100 form-control setinfo-block__input',
                'maxlength' => 32
            ])->label(false) ?>

            <?= $form->field($model, 'email')->textInput([
                'placeholder' => $model->getAttributeLabel('email'),
                'class' => 'w-100 form-control setinfo-block__input',
                'maxlength' => 32,
                'type' => 'email'
            ])->label(false) ?>
        </div>

        <?= Html::submitButton(Yii::t('matodor.chat', 'chat.submit'), ['class' => 'btn btn-orange setinfo-block__submit']) ?>
    <?php ActiveForm::end(); ?>
</div>
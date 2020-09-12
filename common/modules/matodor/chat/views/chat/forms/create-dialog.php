<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var matodor\chat\models\forms\CreateDialog $model */

?>

<div class="create-dialog-container">
    <?php $form = ActiveForm::begin([
        'options' => [
            'class' => 'create-dialog-block',
            'id' => 'create-dialog-form_' . time()
        ]
    ]); ?>

        <?= $form->field($model, 'question')->textInput([
            'placeholder' => $model->getAttributeLabel('question'),
            'class' => 'w-100 form-control create-dialog-block__input',
            'maxlength' => 32
        ])->label(false) ?>

        <?= Html::submitButton(Yii::t('matodor.chat', 'chat.new_conversation'), ['class' => 'btn w-100 create-dialog-block__submit']) ?>

    <?php ActiveForm::end(); ?>
</div>
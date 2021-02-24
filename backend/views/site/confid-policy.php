<?php

use dosamigos\tinymce\TinyMce;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Политика конфиденциальности';
$form = ActiveForm::begin();
?>
<?= $form->field($model, 'text')->widget(TinyMce::class, [
    'language' => 'ru',
    'clientOptions' => [
        'plugins' => 'paste,link',
        'paste_as_text' => true,
    ]
]) ?>
<?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
<?php ActiveForm::end(); ?>

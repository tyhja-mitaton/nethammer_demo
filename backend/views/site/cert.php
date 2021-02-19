<?php

use floor12\files\components\FileInputWidget;
use floor12\files\models\File;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $model backend\models\Cert*/

$this->title = 'Добавление сертификата';
$form = ActiveForm::begin();

$file = File::find()->where(['object_id' => $model->id, 'field' => 'file'])->one();
$model->__set('file', $file);
?>
<?= $form->field($model, 'file')->widget(FileInputWidget::class)?>

<div class="form-group">
    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>

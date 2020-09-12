<?php
/* @var $model backend\models\SinglePageSeo */
/* @var $type integer */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\SinglePageSeo;

$this->title = 'Seo '.SinglePageSeo::getTitle($type);
$id_param = isset($model->id) ? $model->id : 1;
?>
<?php $form = ActiveForm::begin(['action' => 'update-seo', 'errorCssClass' => 'error']); ?>
<?= $form->field($model, 'type')->hiddenInput(['value' => $type])->label(false)?>
<?=\dvizh\seo\widgets\SeoForm::widget([
    'model' => $model,
    'form' => $form,
    'title' => 'SEO '.SinglePageSeo::getTitle($type),
]); ?>
<?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
<?php ActiveForm::end();

$js = <<<JS
$(function() {
    $(document).find('.dvizh-seo .field-seo-modelname').addClass('d-none');
  $(document).find('.dvizh-seo .field-seo-h1').addClass('d-none');
  $(document).find('.dvizh-seo .field-seo-text').addClass('d-none');
  $(document).find('.dvizh-seo .field-seo-meta_index').addClass('d-none');
});
JS;
$this->registerJs($js);
?>

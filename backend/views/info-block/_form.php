<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\tinymce\TinyMce;

/* @var $this yii\web\View */
/* @var $model common\models\InfoBlock */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="info-block-form">

    <?php $form = ActiveForm::begin(['errorCssClass' => 'error']); ?>

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
        \common\models\InfoBlock::MAIN_PAGE_SLIDER => 'слайдер на главной странице',
        \common\models\InfoBlock::INFO_BLOCK => 'информационный блок с преимуществами на главной',
        \common\models\InfoBlock::SERVICE_BLOCK => 'блок с услугой на странице "Услуги"',
        \common\models\InfoBlock::PRODUCT_BLOCK => 'блок с продуктом на странице "Продукты"',
        \common\models\InfoBlock::CASE_BLOCK => 'блок на странице "Кейсы"',
        \common\models\InfoBlock::VACANCY_BLOCK => 'вакансия на странице "Вакансии"'
    ], ['prompt' => 'Выберите тип...']) ?>
    <?= $form->field($model, 'salary', ['options' => ['class' => $model->type !== \common\models\InfoBlock::VACANCY_BLOCK ? 'd-none': '']])->textInput() ?>

    <?= $form->field($model, 'imgs')->widget(floor12\files\components\FileInputWidget::class)?>
    <?= $form->field($model, 'avatar')->widget(floor12\files\components\FileInputWidget::class)?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php
$jobType = \common\models\InfoBlock::VACANCY_BLOCK;
$js = <<<JS
$(document).find('[name="InfoBlock[type]"]').on('change', function() {
  let salaryBlock = $(document).find('.field-infoblock-salary');
    if(parseInt($(this).val(), 10) === $jobType) {
        salaryBlock.removeClass('d-none');
    }else if(!salaryBlock.hasClass('d-none')) {
        salaryBlock.addClass('d-none');
    }
})
JS;
$this->registerJs($js);
?>

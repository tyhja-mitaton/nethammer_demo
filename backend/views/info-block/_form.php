<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\tinymce\TinyMce;

/* @var $this yii\web\View */
/* @var $model common\models\InfoBlock */
/* @var $form yii\widgets\ActiveForm */

$sliderType = \common\models\InfoBlock::MAIN_PAGE_SLIDER;
$infoType = \common\models\InfoBlock::INFO_BLOCK;
$serviceType = \common\models\InfoBlock::SERVICE_BLOCK;
$productType = \common\models\InfoBlock::PRODUCT_BLOCK;
$caseType = \common\models\InfoBlock::CASE_BLOCK;
$jobType = \common\models\InfoBlock::VACANCY_BLOCK;
$designCase = \common\models\InfoBlock::DESIGN;
$photoCase = \common\models\InfoBlock::PHOTOGRAPHY;
$artsCase = \common\models\InfoBlock::DIGITAL_ARTS;
$imgModels = floor12\files\models\File::find()->where(['object_id' => $model->id, 'field' => 'imgs'])->all();
$avatar = floor12\files\models\File::find()->where(['object_id' => $model->id, 'field' => 'avatar'])->one();
$model->__set('imgs', $imgModels);
$model->__set('avatar', $avatar);
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
        $sliderType => 'слайдер на главной странице',
        $infoType => 'информационный блок с преимуществами на главной',
        $serviceType => 'блок с услугой на странице "Услуги"',
        $productType => 'блок с продуктом на странице "Продукты"',
        $caseType => 'блок на странице "Кейсы"',
        $jobType => 'вакансия на странице "Вакансии"'
    ], ['prompt' => 'Выберите тип...']) ?>
    <?= $form->field($model, 'salary', ['options' => ['class' => $model->type !== $jobType ? 'd-none': '']])->textInput() ?>
    <?= $form->field($model, 'tag', ['options' => ['class' => $model->type !== $caseType ? 'd-none': '']])->dropDownList([
        $designCase => 'Design',
        $photoCase => 'Photography',
        $artsCase => 'Digital Arts'
    ], ['prompt' => 'Выберите тип...']) ?>
    <?= $form->field($model, 'priority')->textInput() ?>

    <?= $form->field($model, 'imgs', ['options' => [
            'class' => $model->type !== $serviceType && $model->type !== $productType && $model->type !== $caseType ? 'd-none': ''
    ]])->widget(floor12\files\components\FileInputWidget::class)?>
    <?= $form->field($model, 'avatar', ['options' => [
            'class' => $model->type !== $sliderType && $model->type !== $infoType && $model->type !== $serviceType && $model->type !== $productType ? 'd-none': ''
    ]])->widget(floor12\files\components\FileInputWidget::class)?>
    <?=\dvizh\seo\widgets\SeoForm::widget([
        'model' => $model,
        'form' => $form,
        'title' => 'SEO поля',
    ]); ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php
$hideSeo = $model->type !== $productType && $model->type !== $serviceType;
$js = <<<JS
$(function() {
    $(document).find('.dvizh-seo .field-seo-modelname').addClass('d-none');
  $(document).find('.dvizh-seo .field-seo-h1').addClass('d-none');
  $(document).find('.dvizh-seo .field-seo-text').addClass('d-none');
  $(document).find('.dvizh-seo .field-seo-meta_index').addClass('d-none');
  if("$hideSeo"){
      $(document).find('.dvizh-seo').addClass('d-none');
  }
});
$(document).find('[name="InfoBlock[type]"]').on('change', function() {
  let salaryBlock = $(document).find('.field-infoblock-salary');
  let tagBlock = $(document).find('.field-infoblock-tag');
  let avatarBlock = $(document).find('.field-infoblock-avatar');
  let imgsBlock =  $(document).find('.field-infoblock-imgs');
  let seoBlock = $(document).find('.dvizh-seo');
  let btnLbl = $(document).find('label[for="infoblock-btn_name"]');
  switch (parseInt($(this).val(), 10)) {
    case $sliderType: avatarBlock.removeClass('d-none');imgsBlock.addClass('d-none');btnLbl.text('Ссылка');seoBlock.addClass('d-none');break;
    case $infoType: avatarBlock.removeClass('d-none');imgsBlock.addClass('d-none');seoBlock.addClass('d-none');break;
    case $serviceType: avatarBlock.removeClass('d-none');imgsBlock.removeClass('d-none');seoBlock.removeClass('d-none');break;
    case $productType: avatarBlock.removeClass('d-none');imgsBlock.removeClass('d-none');seoBlock.removeClass('d-none');break;
    case $caseType: avatarBlock.addClass('d-none');imgsBlock.removeClass('d-none');seoBlock.addClass('d-none');tagBlock.removeClass('d-none');break;
    case $jobType: avatarBlock.addClass('d-none');imgsBlock.addClass('d-none');salaryBlock.removeClass('d-none');seoBlock.addClass('d-none');break;
  }
    if(!salaryBlock.hasClass('d-none') && parseInt($(this).val(), 10) !== $jobType) {
        salaryBlock.addClass('d-none');
    }
    if(!tagBlock.hasClass('d-none') && parseInt($(this).val(), 10) !== $caseType) {
        tagBlock.addClass('d-none');
    }
    if(btnLbl.text() === 'Ссылка' && parseInt($(this).val(), 10) !== $sliderType) {
        btnLbl.text('Имя кнопки');
    }
    });
JS;
$this->registerJs($js);
?>

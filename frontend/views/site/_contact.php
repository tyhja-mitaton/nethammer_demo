<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\Appeal */

use backend\models\ConfidPol;
use yii\bootstrap4\Modal;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use yii\helpers\Url;

$this->title = 'Связаться с нами';
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="contact-us">
    <div class="container">
        <h2 class="section-title"><?= Html::encode($this->title) ?></h2>
        <?php $form = ActiveForm::begin([
            'id' => 'contact-form',
            'errorCssClass' => 'error',
            'action' => '/contact',
            'enableAjaxValidation' => true,
            'enableClientValidation' => false,
            'validationUrl' => Url::toRoute(['site/validate-contact-form']),
            'validateOnBlur' => true,
        ]); ?>

            <?= $form->field($model, 'author')
                ->textInput(['placeholder' => 'Дмитрий'])
                ->label('Имя')
            ?>

            <?= $form->field($model, 'phone')
                ->textInput(['placeholder' => '+7 995 995 95 95'])
                ->label('E-mail или телефон')
            ?>

            <?= $form->field($model, 'verifyCode')->widget(Captcha::class) ?>

            <?= Html::submitButton('Отправить <i class="fas fa-chevron-right"></i>',
                ['class' => 'btn btn-blue', 'name' => 'contact-button']
            ) ?>

            <img class="robot" src="images/contacts-robot.jpg" alt="">
            <?php $confidPolModel = ConfidPol::find()->one(); echo '<span class="conf-pol">Отправляя заявку, Вы соглашаетесь с нашей </span>'; ?>
            <?php Modal::begin([
                'title' => 'Политика защиты и обработки персональных данных',
                'toggleButton' => ['label' => 'политикой конфиденциальности', 'tag' => 'a', 'class' => 'conf-pol'],
                'footer' => '',
                'size' => Modal::SIZE_EXTRA_LARGE,
                'id' => 'conf-pol-modal',
            ]); ?>
                <?= $this->render('conf-policy', ['confidPolModel' => $confidPolModel]); ?>
            <?php Modal::end();?>
        <?php ActiveForm::end(); ?>
    </div>
</section>

<?php
$js = <<<JS
$(function() {
  $('#conf-pol-modal').on('shown.bs.modal', function() {console.log('tessst', $(document).find('.modal-backdrop'));
    $(document).find('.modal-backdrop').hide();
    let h5 = $(this).find('.modal-header h5');
    h5.appendTo('#conf-pol-modal .modal-header');
  });
});
JS;
$this->registerJs($js);
?>

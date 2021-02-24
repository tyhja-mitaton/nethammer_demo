<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\Appeal */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = 'Связаться с нами';
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="contact-us">
<div class="container">
    <h2 class="section-title"><?= Html::encode($this->title) ?></h2>
            <?php $form = ActiveForm::begin(['id' => 'contact-form', 'errorCssClass' => 'error', 'action' => '/contact']); ?>

                <?= $form->field($model, 'author')->textInput(['placeholder' => 'Дмитрий'])->label('Имя') ?>

                <?= $form->field($model, 'phone')->textInput(['placeholder' => '+7 995 995 95 95'])->label('E-mail или телефон') ?>

                <?= $form->field($model, 'verifyCode')->widget(Captcha::class) ?>

                    <?= Html::submitButton('Отправить <i class="fas fa-chevron-right"></i>', ['class' => 'btn btn-blue', 'name' => 'contact-button']) ?>
    <img class="robot" src="images/contacts-robot.jpg" alt="">
    <?=Html::a('Политика конфиденциальности', \yii\helpers\Url::to(['conf-policy']), ['class' => 'conf-pol', 'target' => '_blank'])?>
            <?php ActiveForm::end(); ?>
</div>
</section>

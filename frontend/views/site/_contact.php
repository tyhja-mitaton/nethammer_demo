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
            <?php $form = ActiveForm::begin(['id' => 'contact-form', 'errorCssClass' => 'error', 'action' => '/site/contact']); ?>

                <?= $form->field($model, 'author')->textInput(['placeholder' => 'Дмитрий', 'value' => 'site@mail.ru'])->label('Имя') ?>

                <?= $form->field($model, 'phone')->textInput(['placeholder' => '+7 995 995 95 95'])->label('E-mail или телефон') ?>

                    <?= Html::submitButton('Отправить <i class="fas fa-chevron-right"></i>', ['class' => 'btn btn-blue', 'name' => 'contact-button']) ?>
    <img src="images/contacts-robot.jpg" alt="">
            <?php ActiveForm::end(); ?>
</div>
</section>

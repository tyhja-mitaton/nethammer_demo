<?php
/* @var $model \frontend\models\Review */
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\captcha\Captcha;

$this->title = 'Оставить отзыв';
 ?>
<section class="contact-us">
    <div class="container">
        <h2 class="section-title"><?= Html::encode($this->title) ?></h2>
        <?php $form = ActiveForm::begin(['id' => 'contact-form', 'errorCssClass' => 'error', 'action' => '/site/leave-review']); ?>

        <?= $form->field($model, 'author')->textInput()->label('Имя или организация') ?>

        <?= $form->field($model, 'text')->textarea(['placeholder' => 'сообщение'])->label('Отзыв') ?>

        <?= Html::submitButton('Отправить <i class="fas fa-chevron-right"></i>', ['class' => 'btn btn-blue', 'name' => 'contact-button']) ?>
        <img src="images/contacts-robot.jpg" alt="">
        <?php ActiveForm::end(); ?>
    </div>
</section>

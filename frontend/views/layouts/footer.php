<?php

use backend\models\ContactData;
use yii\bootstrap4\Nav;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$searchModel = new \backend\models\InfoBlockSearch();
$contactDataModel = ContactData::find()->one();
$certModel = \backend\models\Cert::find()->one();
$certFile = $certModel ? floor12\files\models\File::find()
    ->where(['object_id' => $certModel->id, 'field' => 'file'])
    ->one() : null;

?>

<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <a class="logo" href="<?=Yii::$app->homeUrl?>">
                    <img src="images/logo.png" alt="">
                </a>
                <?php $form = ActiveForm::begin([
                    'action' => ['search'],
                    'method' => 'get',
                    'errorCssClass' => 'error',
                    'options' => ['class' => 'search-form d-block d-lg-none']
                ]); ?>
                    <?= $form->field($searchModel, 'search')->textInput(['placeholder' => 'Поиск'])->label(false) ?>
                    <?= Html::submitButton('<img src="images/search.png" alt="">') ?>
                <?php ActiveForm::end(); ?>

                <ul class="social">
                    <?php foreach ([
                        [$contactDataModel->vk_link, 'fab fa-vk'],
                        [$contactDataModel->fb_link, 'fab fa-facebook-f'],
                        [$contactDataModel->twitter_link, 'fab fa-twitter'],
                        [$contactDataModel->tg_link, 'fab fa-telegram'],
                    ] as $item) { ?>
                        <?php if ($item[0] !== null && $item[0] !== '') { ?>
                            <li>
                                <a href="<?= $item[0] ?>" target="_blank">
                                    <i class="<?= $item[1] ?>"></i>
                                </a>
                            </li>
                        <?php } ?>
                    <?php } ?>
                </ul>

                <div class="mb-n2 footer__contacts">
                    <p>
                        <i class="fa fa-phone"></i> <a href="tel:+73522229159">+7 (3522) 229-159</a>
                    </p>
                    <p>
                        <i class="fa fa-envelope"></i> <a href="mailto:foxis@nethammer.ru">foxis@nethammer.ru</a>
                    </p>
                    <p>
                        <i class="fa fa-link"></i> <a href="http://support.nethammer.ru">support.nethammer.ru</a>
                    </p>
                    <?php if(isset($certFile->href)): ?>
                        <p>
                            <i class="fas fa-file-pdf"></i>
                            <a href="<?=$certFile->href?>" target="_blank">SLA</a>
                        </p>
                    <?php endif;?>
                </div>
            </div>

            <div class="col-lg-9 d-md-flex flex-md-column">
                <?= Nav::widget([
                    'options' => ['class' => 'footer-menu'],
                    'items' => $menuItems,
                ]); ?>
                <div class="copyright flex-md-grow-1 d-lg-flex justify-content-lg-end align-items-lg-end">
                    nethammer.ru © 2014-<?=date("Y")?>
                </div>
            </div>
        </div>
    </div>
</footer>

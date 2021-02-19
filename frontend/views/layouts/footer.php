<?php

use backend\models\ContactData;
use floor12\files\models\File;
use yii\bootstrap4\Nav;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$searchModel = new \backend\models\InfoBlockSearch();
$contactDataModel = ContactData::find()->one();
$certModel = \backend\models\Cert::find()->one();
$certFile = $certModel ? floor12\files\models\File::find()->where(['object_id' => $certModel->id, 'field' => 'file'])->one() : null;
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
                    <?php if(isset($contactDataModel->vk_link) && $contactDataModel->vk_link !== ''){ ?><li><a href="<?=isset($contactDataModel->vk_link) ? $contactDataModel->vk_link : '#'?>" target="_blank"><i class="fab fa-vk"></i></a></li><?php } ?>
                    <?php if(isset($contactDataModel->fb_link) && $contactDataModel->fb_link !== ''){ ?><li><a href="<?=isset($contactDataModel->fb_link) ? $contactDataModel->fb_link : '#'?>" target="_blank"><i class="fab fa-facebook-f"></i></a></li><?php } ?>
                    <?php if(isset($contactDataModel->twitter_link) && $contactDataModel->twitter_link !== ''){ ?><li><a href="<?=isset($contactDataModel->twitter_link) ? $contactDataModel->twitter_link : '#'?>" target="_blank"><i class="fab fa-twitter"></i></a></li><?php } ?>
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
                            <i class="fas fa-file-pdf"></i> <a href="<?=$certFile->href?>" target="_blank">Сертификат</a>
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

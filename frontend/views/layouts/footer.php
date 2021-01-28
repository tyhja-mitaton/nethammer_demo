<?php

use backend\models\ContactData;
use yii\bootstrap4\Nav;

$contactDataModel = ContactData::find()->one();?>
<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <a class="logo" href="<?=Yii::$app->homeUrl?>">
                    <img src="images/logo.png" alt="">
                </a>
                <form class="search-form d-block d-lg-none">
                    <input type="text" placeholder="Поиск">
                    <button type="button">
                        <img src="images/search.png" alt="">
                    </button>
                </form>
                <ul class="social">
                    <?php if(isset($contactDataModel->vk_link) && $contactDataModel->vk_link !== ''){ ?><li><a href="<?=isset($contactDataModel->vk_link) ? $contactDataModel->vk_link : '#'?>"><i class="fab fa-vk"></i></a></li><?php } ?>
                    <?php if(isset($contactDataModel->fb_link) && $contactDataModel->fb_link !== ''){ ?><li><a href="<?=isset($contactDataModel->fb_link) ? $contactDataModel->fb_link : '#'?>"><i class="fab fa-facebook-f"></i></a></li><?php } ?>
                    <?php if(isset($contactDataModel->twitter_link) && $contactDataModel->twitter_link !== ''){ ?><li><a href="<?=isset($contactDataModel->twitter_link) ? $contactDataModel->twitter_link : '#'?>"><i class="fab fa-twitter"></i></a></li><?php } ?>
                </ul>
                <p>
                    <a href="tel:+73522229159">+7 (3522) 229-159</a>
                </p>
                <p>
                    <a href="mailto:foxis@nethammer.ru">foxis@nethammer.ru</a>
                </p>
            </div>
            <div class="col-lg-9">
                <?= Nav::widget([
                    'options' => ['class' => 'footer-menu'],
                    'items' => $menuItems,
                ]); ?>
                <div class="copyright">
                    nethammer.ru © 2014-2021
                </div>
            </div>
        </div>
    </div>
</footer>

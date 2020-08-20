<?php

use yii\bootstrap4\Nav; ?>
<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-9">
                <a class="logo" href="<?=Yii::$app->homeUrl?>">
                    <img src="images/logo.png" alt="">
                </a>
                <form class="search-form d-block d-lg-none">
                    <input type="text" placeholder="Поиск">
                    <button type="button">
                        <img src="images/search.png" alt="">
                    </button>
                </form>
                <?= Nav::widget([
                    'options' => ['class' => 'footer-menu'],
                    'items' => $menuItems,
                ]); ?>
            </div>
            <div class="col-lg-3">
                <ul class="social">
                    <li><a href="#"><i class="fab fa-vk"></i></a></li>
                    <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                    <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                </ul>
            </div>
        </div>
    </div>
</footer>

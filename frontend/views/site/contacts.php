<?php
/* @var $model \frontend\models\Appeal */

$this->title = 'Контакты';
$this->params['breadcrumbs'][] = $this->title;

use yii\bootstrap4\Breadcrumbs;
use yii\helpers\Html; ?>
<div class="contact-page">
    <div class="container">
        <h1 class="page-title"><?= Html::encode($this->title) ?></h1>
        <nav>
            <?= Breadcrumbs::widget([
                'tag' => 'ol',
                'itemTemplate' => '<li class="breadcrumb-item">{link}</li>',
                'activeItemTemplate' => '<li class="breadcrumb-item active">{link}</li>',
                'homeLink' => ['label' => 'Главная', 'url' => '/'],
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
        </nav>
    </div>
    <div class="container">
    <div class="row">
        <div class="col-lg-5 pl-5 order-lg-1">
            <div class="label">
                <i class="fas fa-map-marker-alt"></i> Адрес:
            </div>
            <p>ул. Максима Горького, 155 Офис 105</p>
            <div class="label">
                <i class="fas fa-phone-alt"></i> Телефон:
            </div>
            <p><a href="tel:88003001805">8 800 300 1805</a></p>
            <div class="label">
                <img src="" alt=""> Соц сети:
            </div>
            <ul class="social">
                <li><a href="#"><i class="fab fa-vk"></i></a></li>
                <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                <li><a href="#"><i class="fab fa-twitter"></i></a></li>
            </ul>
        </div>
        <div class="col-lg-7">
            <div class="map">
                <script type="text/javascript" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3Ae93d4e092c589ae408849cecfe6bb11592e97d74c6737c66e67ac359f1884084&amp;width=100%25&amp;height=360&amp;lang=ru_RU&amp;scroll=false"></script>
            </div>
        </div>
    </div>
    </div>
    <?= $this->render('_contact', ['model' => $model]); ?>
</div>

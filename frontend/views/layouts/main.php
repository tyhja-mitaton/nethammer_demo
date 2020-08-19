<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

AppAsset::register($this);
Yii::$app->name = 'Nethammer';
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <base href="../">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
    <meta name="robots" content="index,follow">
    <?php $this->registerCsrfMetaTags() ?>
    <link rel="icon" type="image/x-icon" href="images/favicon.ico">
    <link rel="shortcut icon" href="/images/favicon.png" type="image/png">
    <link rel="apple-touch-icon" sizes="57x57" href="/images/57x57.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/images/72x72.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/images/32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/images/96x96.png">

    <meta name="theme-color" content="#ffba00">
    <link rel="manifest" href="manifest.webmanifest">

    <meta name="cannonical" content="https://foodband.ru/">

    <meta name="og:type" content="website">
    <meta name="og:url" content="http://site.ru/">
    <meta name="og:title" content="Заголовок страницы">
    <meta name="og:description" content="SEO описание страницы">
    <meta name="og:image" content="/images/logo.jpg">
    <meta name="description" content="SEO описание страницы">
    <meta name="keywords" content="Ключевые слова">
    <link rel="stylesheet" href="css/owl.carousel.css">
    <link rel="stylesheet" href="css/owl.theme.default.css">
    <link rel="stylesheet" href="css/font-awesome.css">
    <link rel="stylesheet" href="css/jquery.fancybox.css">
    <link rel="stylesheet" href="css/styles.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700&display=swap" rel="stylesheet">
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

    <header class="container">
        <div class="row align-items-end">
            <div class="col-lg-4 d-flex align-items-center">
                <button class="navbar-toggler" data-toggle="collapse" data-target="#w0-collapse">
                    <img src="images/menu.png" alt="">
                </button>
                <a class="logo" href="<?=Yii::$app->homeUrl?>">
                    <img src="images/molot.png" alt="">
                    <img src="images/logo.png" alt="">
                </a>
            </div>
            <div class="col-lg-8">
            <?php
            NavBar::begin([
                //'brandLabel' => Yii::$app->name,
                //'brandImage' => 'images/molot.png',
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar navbar-expand-lg',
                ],
                'renderInnerContainer' => false,
                'togglerContent' => false//'<img src="images/menu.png" alt="">'
            ]);
            $menuItems = [
                ['label' => 'Главная', 'url' => ['/site/index']],
                ['label' => 'О компании', 'items' => [
                    ['label' => 'Кейсы', 'url' => ['/site/cases']],
                    ['label' => 'Вакансии', 'url' => ['/site/vacancies']],
                    ['label' => 'Отзывы', 'url' => ['/site/review']]
                ]
                ],
                ['label' => 'Продукты', 'url' => ['/site/products']],
                ['label' => 'Услуги', 'url' => ['/site/services']],
                ['label' => 'Контакты', 'url' => ['/site/contact']],
            ];
            if (Yii::$app->user->isGuest) {
                $menuItems[] = ['label' => 'Signup', 'url' => ['/site/signup']];
                $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
            } else {
                $menuItems[] = '<li>'
                    . Html::beginForm(['/site/logout'], 'post')
                    . Html::submitButton(
                        'Logout (' . Yii::$app->user->identity->username . ')',
                        ['class' => 'btn btn-link logout']
                    )
                    . Html::endForm()
                    . '</li>';
            }
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav ml-auto'],
                'items' => $menuItems,
            ]);
            NavBar::end();
            ?>
            </div>
        </div>
        <div class="row align-items-center pt-lg-3">
            <div class="col-lg-4">
                <form class="search-form">
                    <input type="text" placeholder="Поиск">
                    <button type="button">
                        <img src="images/search.png" alt="">
                    </button>
                </form>
            </div>
            <div class="col-lg-8 d-flex">
                <ul class="social">
                    <li><a href="#"><i class="fab fa-vk"></i></a></li>
                    <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                    <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                </ul>
            </div>
        </div>
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </header>

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

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

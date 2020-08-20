<?php
use common\widgets\Alert;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;
use yii\helpers\Html;
use yii\bootstrap4\Breadcrumbs;
?>
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
            if (Yii::$app->user->isGuest) {
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
    </header>
<div class="container">
    <h1 class="page-title"><?= Html::encode($this->title) ?></h1>
    <nav>
        <?= Breadcrumbs::widget([
            'tag' => 'ol',
            'itemTemplate' => '<li class="breadcrumb-item">{link}</li>',
            'activeItemTemplate' => '<li class="breadcrumb-item active">{link}</li>',
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
    </nav>
</div>
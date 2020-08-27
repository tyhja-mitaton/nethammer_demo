<?php
use yii\helpers\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;
use yii\helpers\Url;

/** @var \yii\web\View $this */
/** @var string $content */

?>

<header class="main-header">
    <?= Html::a('<span class="logo-mini"><img src="' . Url::to('@web/images/logo.png') . '"></span><span class="logo-lg">Департамент</span>', Yii::$app->homeUrl, ['class' => 'logo']) ?>

    <nav class="navbar navbar-static-top navbar-expand-lg" role="navigation">
        <a href="#" class="sidebar-toggle mr-auto" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li class="nav-item dropdown user user-menu">
                    <a href="#" class="nav-link dropdown-toggle"  href="#" role="button" id="dropdownUser" data-toggle="dropdown">
                        <img src="<?= Url::toRoute(['/images/logo_big.png'])?>" class="user-image" alt="User Image"/>
                        <span class="hidden-xs"><?= isset(Yii::$app->user->identity->id) ? \dektrium\user\models\User::findIdentity(Yii::$app->user->identity->id)->username: '' ?></span>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="dropdownUser">
                        <li class="user-header">
                            <img src="<?= Url::toRoute(['/images/logo_big.png'])?>" class="rounded-circle" alt="User Image"/>
                            <p><?= isset(Yii::$app->user->identity->id) ? \dektrium\user\models\User::findIdentity(Yii::$app->user->identity->id)->username: '' ?></p>
                        </li>
                        <!--
                            <li class="user-body">
                                <div class="col-xs-4 text-center">
                                    <a href="#">Followers</a>
                                </div>
                                <div class="col-xs-4 text-center">
                                    <a href="#">Sales</a>
                                </div>
                                <div class="col-xs-4 text-center">
                                    <a href="#">Friends</a>
                                </div>
                            </li>
                        -->
                        <li class="user-footer">
                            <!--
                                <div class="pull-left">
                                    <a href="#" class="btn btn-default btn-flat">Профиль</a>
                                </div>
                            -->
                            <div class="pull-right">
                                <?= Html::a(
                                    'Выход',
                                    ['user/security/logout'],
                                    ['data-method' => 'post', 'class' => 'btn btn-default btn-flat']
                                ) ?>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>

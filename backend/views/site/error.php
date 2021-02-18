<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\bootstrap4\Breadcrumbs;
use yii\helpers\Html;

$this->title = $message;
$this->params['breadcrumbs'][] = $this->title;
//$this->context->layout = '@frontend/views/layouts/main';
?>
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

        <div class="text-center my-5">
            <h1><?= Html::encode($name) ?></h1>
            <p>Что-то пошло не так.. </p>
            <p><a href="<?=Yii::$app->homeUrl?>" class="btn btn-blue-o d-inline-flex mt-3">Вернуться на главную</a></p>
        </div>
    </div>

</div>

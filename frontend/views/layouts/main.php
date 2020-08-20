<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
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
<?php $this->beginBody();
$menuItems = [
    ['label' => 'Главная', 'url' => ['/site/index']],
    ['label' => 'О компании', 'items' => [
        ['label' => 'Кейсы', 'url' => ['/site/cases']],
        ['label' => 'Вакансии', 'url' => ['/site/job']],
        ['label' => 'Отзывы', 'url' => ['/site/review']]
    ]
    ],
    ['label' => 'Продукты', 'url' => ['/site/products']],
    ['label' => 'Услуги', 'url' => ['/site/services']],
    ['label' => 'Контакты', 'url' => ['/site/contact']],
];
?>

    <?= $this->render('header', ['menuItems' => $menuItems]); ?>
    <?= Alert::widget() ?>
    <?= $content?>
    <?= $this->render('footer', ['menuItems' => $menuItems]); ?>


<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

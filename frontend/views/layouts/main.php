<?php

/* @var $this \yii\web\View */
/* @var $content string */

use common\models\InfoBlock;
use frontend\models\Review;
use yii\helpers\Html;
use frontend\assets\AppAsset;
use common\widgets\Alert;

AppAsset::register($this);
Yii::$app->name = 'Nethammer';

$userIsBot = \common\helpers\Helpers::userIsBot(\Yii::$app->request->userAgent);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-188854628-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-188854628-1');
    </script>
    <meta charset="<?= Yii::$app->charset ?>">
    <base href="../">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
    <meta name="robots" content="index,follow">
    <?php $this->registerCsrfMetaTags() ?>
    <link rel="shortcut icon" href="/images/favicon.png" type="image/png">

    <meta name="cannonical" content="https://<?= CURRENT_DOMAIN ?>/">
    <meta name="og:type" content="website">
    <meta name="og:image" content="/images/logo.jpg">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700&display=swap" rel="stylesheet">
    <title><?= Html::encode($this->title) ?></title>
    <!-- Yandex.Metrika counter -->
    <script async type="text/javascript" >
        (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
            m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
        (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

        ym(71829280, "init", {
            clickmap:true,
            trackLinks:true,
            accurateTrackBounce:true,
            webvisor:true
        });
    </script>
    <noscript><div><img src="https://mc.yandex.ru/watch/71829280" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
    <!-- /Yandex.Metrika counter -->
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody();

$vacanciesCount = InfoBlock::find()->where(['type' => InfoBlock::VACANCY_BLOCK])->count();
$productsCount = InfoBlock::find()->where(['type' => InfoBlock::PRODUCT_BLOCK])->count();
$servicesCount = InfoBlock::find()->where(['type' => InfoBlock::SERVICE_BLOCK])->count();
$casesCount = InfoBlock::find()->where(['type' => InfoBlock::CASE_BLOCK])->count();
$reviewsCount = Review::find()->where(['is_visible' => 1])->count();

$menuItems = [
    ['label' => 'Главная', 'url' => ['/site/index']],
];
$items = [];
if($casesCount > 0) {
    $items[] = ['label' => 'Кейсы', 'url' => ['/site/cases']];
}
if($vacanciesCount > 0) {
    $items[] = ['label' => 'Вакансии', 'url' => ['/site/job']];
}
if($reviewsCount > 0) {
    $items[] = ['label' => 'Отзывы', 'url' => ['/site/reviews']];
}
if($casesCount > 0 || $vacanciesCount > 0 || $reviewsCount > 0) {
    $menuItems[] = ['label' => 'О компании', 'items' => $items];
}
if($productsCount > 0) {
    $menuItems[] = ['label' => 'Продукты', 'url' => ['/site/products']];
}
if($servicesCount > 0) {
    $menuItems[] = ['label' => 'Услуги', 'url' => ['/site/services']];
}
$menuItems[] = ['label' => 'Контакты', 'url' => ['/site/contact']];
?>

    <?= $this->render('header', ['menuItems' => $menuItems]); ?>
    <?= $content?>
    <?= $this->render('footer', ['menuItems' => $menuItems]); ?>

    <?php if (
        (!isset($this->params['popupChatDisabled']) || !$this->params['popupChatDisabled'])
        && !$userIsBot
    ) {
        /*echo \matodor\chat\widgets\PopupChat::widget([
            'options' => [
                'requestParams' => [],
                'toggleOptions' => [
                    'class' => ['togglePopup']
                ]
            ]
        ]);*/
    } ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

<?php
use yii\bootstrap4\Nav;
use yii\helpers\Html;
use yii\helpers\Url;

$items = [
    '<li class="nav-item header">Редактирование данных</li>',
    [
        'label' => '<i class="fa fa-circle-o"></i> Админ-панель',
        'url' => ['/']
    ],
    [
        'label' => '<i class="fa fa-circle-o"></i> Инф. блоки',
        'url' => ['/info-block']
    ],
    [
        'label' => '<i class="fa fa-circle-o"></i> Тэги кейсов',
        'url' => ['/tag']
    ],
    [
        'label' => '<i class="fa fa-circle-o"></i> Обращения',
        'url' => ['/appeal']
    ],
    [
        'label' => '<i class="fa fa-circle-o"></i> Отзывы',
        'url' => ['/review']
    ],
    [
        'label' => '<i class="fa fa-circle-o"></i> Рабочие процессы',
        'url' => ['/work-process']
    ],
    [
        'label' => '<i class="fa fa-circle-o"></i> Расценки услуг',
        'url' => ['/service-price']
    ],
    [
        'label' => '<i class="fa fa-circle-o"></i> Контактная форма',
        'url' => ['/site/contact']
    ],
    [
        'label' => '<i class="fa fa-circle-o"></i> Дополнительные блоки',
        'url' => ['/extra-block']
    ],
    [
        'label' => '<i class="fa fa-circle-o"></i> Верхний блок Кейсов',
        'url' => ['/site/case-upper-block']
    ],
    [
        'label' => '<i class="fa fa-circle-o"></i> SEO главной страницы',
        'url' => ['/site/single-seo-main']
    ],
    [
        'label' => '<i class="fa fa-circle-o"></i> SEO страницы продуктов',
        'url' => ['/site/single-seo-products']
    ],
    [
        'label' => '<i class="fa fa-circle-o"></i> SEO страницы услуг',
        'url' => ['/site/single-seo-services']
    ],
    [
        'label' => '<i class="fa fa-circle-o"></i> SEO страницы кейсов',
        'url' => ['/site/single-seo-cases']
    ],
    [
        'label' => '<i class="fa fa-circle-o"></i> SEO страницы вакансий',
        'url' => ['/site/single-seo-job']
    ],
    [
        'label' => '<i class="fa fa-circle-o"></i> SEO страницы отзывов',
        'url' => ['/site/single-seo-reviews']
    ],
    [
        'label' => '<i class="fa fa-circle-o"></i> SEO страницы контактов',
        'url' => ['/site/single-seo-contacts']
    ],
];

if (Yii::$app->user->can('admin'))
{ ?>
<aside class="main-sidebar">
    <section class="sidebar">
        <?= Nav::widget(
            [
                'encodeLabels' => false,
                'options' => ['class' => 'nav flex-column sidebar-menu'],
                'items' => $items
            ]
        ); ?>
    </section>
</aside>
<?php } ?>

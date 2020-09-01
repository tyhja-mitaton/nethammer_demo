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
        'label' => '<i class="fa fa-circle-o"></i> Обращения',
        'url' => ['/appeal']
    ],
    [
        'label' => '<i class="fa fa-circle-o"></i> Отзывы',
        'url' => ['/review']
    ],
    [
        'label' => '<i class="fa fa-circle-o"></i> Контактная форма',
        'url' => ['/site/contact']
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

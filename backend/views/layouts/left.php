<?php
use yii\bootstrap4\Nav;
use yii\helpers\Html;
use yii\helpers\Url;

$items = [
    '<li class="nav-item header">Общая информация о заявках</li>',
    [
        'label' => '<i class="fa fa-circle-o"></i> Сезоны охоты',
        'url' => ['/hunting-seasons/index']
    ],
    [
        'label' => '<i class="fa fa-circle-o"></i> Заявки на охоту',
        'url' => ['/hunter-request/index']
    ],
    [
        'label' => '<i class="fa fa-circle-o"></i> <span style="font-size: 12px">Уведомления об отработке</span>',
        'url' => ['/event-notifications/index']
    ],
    [
        'label' => '<i class="fa fa-circle-o"></i> Охотники',
        'url' => ['/hunters/index']
    ],
    [
        'label' => '<i class="fa fa-circle-o"></i> Аннулированные билеты',
        'url' => ['/canceled-hunter-tickets/index']
    ],
    [
        'label' => '<i class="fa fa-circle-o"></i> Разрешения на охоту',
        'url' => ['/hunting-permits/index']
    ],
    '<li class="nav-item header">Редактирование данных</li>',
    [
        'label' => '<i class="fa fa-circle-o"></i> Причины отказа',
        'url' => ['/rejection-reasons/index']
    ],
    [
        'label' => '<i class="fa fa-circle-o"></i> Охотничьи угодья',
        'url' => ['/hunting-areas/index']
    ],
    [
        'label' => '<i class="fa fa-circle-o"></i> Виды ресурсов',
        'url' => ['/types-of-resources/index']
    ],
    [
        'label' => '<i class="fa fa-circle-o"></i> Виды мероприятий',
        'url' => ['/types-of-events/index']
    ],
    [
        'label' => '<i class="fa fa-circle-o"></i> Сроки охоты',
        'url' => ['/hunting-periods/index']
    ],
    [
        'label' => '<i class="fa fa-circle-o"></i> Охотничьи ресурсы',
        'url' => ['/hunting-resources/index']
    ],
    [
        'label' => '<i class="fa fa-circle-o"></i> Квоты',
        'url' => ['/hunting-quotas/index']
    ],
    [
        'label' => '<i class="fa fa-circle-o"></i> Члены комиссии',
        'url' => ['/comission-member/index']
    ],
    [
        'label' => '<i class="fa fa-circle-o"></i> <span style="font-size: 12px">Формирование <br> протоколов для отработчиков</span>',
        'url' => ['/notification-protocols/event-list']
    ],

    '<li class="nav-item header">Выгрузки и реестры</li>',
    [
        'label' => '<i class="fa fa-circle-o"></i> Реестры',
        'url' => ['/registry/index']
    ],
    [
        'label' => '<i class="fa fa-circle-o"></i> Протоколы по заявкам <br>на охоту',
        'url' => ['/protocols/index']
    ],
    [
        'label' => '<i class="fa fa-circle-o"></i> <span style="font-size: 12px">Протоколы <br> для мероприятий по отработке</span>',
        'url' => ['/notification-protocols/index']
    ],
];

if (Yii::$app->user->can('admin'))
{
    $items[] = '<li class="nav-item header">Администрирование</li>';
    $items[] = [
        'label' => '<i class="fa fa-circle-o"></i> Пользователи',
        'url' => ['/user/admin/index']
    ];
}

?>
<aside class="main-sidebar">
    <section class="sidebar">
        <?= Nav::widget(
            [
                'encodeLabels' => false,
                'options' => ['class' => 'nav flex-column sidebar-menu'],
                'items' => $items
            ]
        ); ?>

        <!-- <<ul class="sidebar-menu" data-widget="tree">
            li>
                <a href="#">
                    <i class="fa fa-circle-o"></i> <span>Справочники</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu menu-open">
                    <li>
                        <a href="#">
                            <i class="fa fa-circle-o"></i> Периоды охоты
                        </a>
                    </li>
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-circle-o"></i> <span>Охотничьи ресурсы</span>
                            <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li>
                                <a href="#">
                                    <i class="fa fa-circle-o"></i> Виды ресурсов
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
        </ul> -->
    </section>
</aside>

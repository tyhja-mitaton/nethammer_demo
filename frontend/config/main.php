<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'language' => 'ru-RU',
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'modules' => [
        'user' => [
            'as frontend' => \dektrium\user\filters\FrontendFilter::class,
            /*'class'  => 'dektrium\user\Module',
            'admins' => ['admin']*/
        ],
        'files' => [
            'class' => 'floor12\files\Module',
            'storage' => '@app/storage',
            'cache' => '@app/storage_cache',
            'token_salt' => 'some_random_salt',
        ],
        /*'sitemap' => [
            'class' => 'himiklab\sitemap\Sitemap',
            'models' => [
                'common\models\InfoBlock',
            ],
        ],*/
        'sitemap' => [
            'class' => 'enchikiben\sitemap\Sitemap',
            'controllerDirAlias' => '@frontend/controllers'
        ],
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
            'baseUrl' => '',
            'csrfCookie' => [
                'domain' => '.' . CURRENT_DOMAIN
            ],
        ],
        'user' => [
            /*'identityClass' => 'common\models\User',*/
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity', 'httpOnly' => true, 'path' => '/', 'domain' => '.' . CURRENT_DOMAIN],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'site-session',
            'cookieParams' => [
                'lifetime' => 2 * 24 * 3600,
                'httpOnly' => true,
                'path' => '/',
                'domain' => '.' . CURRENT_DOMAIN
            ],
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '/' => 'site/index',
                ['pattern' => 'sitemap', 'route' => 'sitemap/default/index', 'suffix' => '.xml'],

                'cases/<tag:[a-z0-9_\-]+>-<tagId:\d+>/<page:\d+>'=> 'site/cases',
                'cases/<tag:[a-z0-9_\-]+>-<tagId:\d+>'=> 'site/cases',
                'cases/<page:\d+>'=> 'site/cases',

                'product/<slug:[a-z0-9_\-]+>' => 'site/product-page',
                //'service/<id:\d+>' => 'site/service-page',
                'service/<slug:[a-z0-9_\-]+>'=> 'site/service-page',
                'conf-policy' => 'site/conf-policy',

                //'service/<slug:[a-z0-9_\-]+>' => 'service/<slug:[a-z0-9_\-]+>/<id:\d+>'
                //'service/<slug:[a-z0-9_\-]+>' => 'service/<id:\d+>',

                '<action:\w+>' => 'site/<action>',
            ],
        ],

    ],
    'params' => $params,
];

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
            ],
        ],

    ],
    'params' => $params,
];

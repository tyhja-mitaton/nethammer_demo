<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'bootstrap' => ['chat'],
    'modules' => [
        'rbac' => [
            'class' => \dektrium\rbac\RbacWebModule::class,
        ],
        'user' => [
            'class' => \dektrium\user\Module::class,
            'admins' => ['admin'],
            'enableConfirmation' => false,
            'enableRegistration' => false,
            /*'modelMap' => [
                'User' => \common\models\User::class,
            ],*/
        ],
        'files' => [
            'class' => 'floor12\files\Module',
            'storage' => '@frontend/storage',
            'cache' => '@frontend/storage_cache',
            'token_salt' => 'some_random_salt',
        ],
        'chat' => [
            'class' => \matodor\chat\ChatModule::class,
            'components' => [
                'worker' => [
                    'class' => \matodor\chat\core\ChatWorker::class,
                    'bindIp' => '127.0.0.1',
                    'bindPort' => 9090,
                    'csrfParams' => [
                        '_csrf-backend',
                        '_csrf-frontend'
                    ],
                    'enableCookieValidation' => true,
                ],
            ],
        ],
    ],
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'assetManager' => [
            'bundles' => [
                'yii\bootstrap\BootstrapAsset' => false,
                'yii\bootstrap\BootstrapPluginAsset' => false,
            ],
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.yandex.ru',
                'username' => 'n3thammer@yandex.ru',
                'password' => 'hammer45Kgn',
                'port' => '587',
                'encryption' => 'tls',
                //'streamOptions' => [ 'ssl' => [ 'allow_self_signed' => true, 'verify_peer' => false, 'verify_peer_name' => false, ], ]
            ],
        ],
        'i18n' => [
            'translations' => [
                'matodor.chat' => [
                    'class' => \yii\i18n\DbMessageSource::class,
                    'enableCaching' => false,
                    'messageTable' => '{{%message}}',
                    'sourceMessageTable' => '{{%source_message}}',
                    'sourceLanguage' => 'en-US',
                    'forceTranslation' => true
                ],
                '*' => [
                    'class' => \yii\i18n\DbMessageSource::class,
                    'enableCaching' => true,
                    'messageTable' => '{{%message}}',
                    'sourceMessageTable' => '{{%source_message}}'
                ],
            ]
        ]
    ],
];

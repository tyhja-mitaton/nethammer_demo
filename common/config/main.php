<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
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
    ],
];

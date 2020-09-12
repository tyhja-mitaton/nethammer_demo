Требования:
- Модуль [dektrium/yii2-user](https://github.com/dektrium/yii2-user)

Выполнить миграции:
```
php yii migrate --migrationPath=common/modules/matodor/chat/migrations
```

Добавить в composer.json:
```json
"require": {
    "workerman/workerman": "*",
    "npm-asset/moment":  "*",
    "npm-asset/tinysort":  "*",
    "npm-asset/form-serializer":  "*",
    "bower-asset/jquery-easing-original": "*",
    "bower-asset/jquery-tmpl": "*",
},
"autoload": {
    "psr-4": {
        "matodor\\chat\\": "common/modules/matodor/chat",
    }
}
```

Установить одинаковые cookieValidationKey для frontend и backend.

Добавить в common\config\main.php:
```php
'bootstrap' => [
    'chat'
],
'modules' => [
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
                'cookieValidationKey' => 'COOKIE_KEY_HERE',
            ],
        ],
    ],
],
```


Добавить в common\config\main-local.php:
```php
'components' => [
    'urlManager' => [
        'class' => 'yii\web\UrlManager',
        'scriptUrl' => 'http://temper.test/' // Сюда свой домен
    ]
]
```

Для запуска чата:
```php
php yii chat/listener/run start
```
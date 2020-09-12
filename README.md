Первоначальная настройка:
```
composer install
php init
```

Изменить CURRENT_DOMAIN в backend/web/index.php, frontend/web/index.php на свой:
```
defined('CURRENT_DOMAIN') or define('CURRENT_DOMAIN', 'nethammer.test');
```

Настроить подключение к базе в файле common/config/main-local.php

Выполнить миграции:
```
php yii migrate/up --migrationPath=@yii/rbac/migrations
php yii migrate/up --migrationPath=@vendor/dektrium/yii2-user/migrations
php yii migrate/up --migrationPath=@vendor/yiisoft/yii2/i18n/migrations
php yii migrate --migrationPath=common/modules/matodor/chat/migrations
php yii migrate
```

Создание миграции:
```php
php yii migrate/create <name>
```

Данные от админа:
```
admin:admin
```

Документация:
> - dektrium/yii2-user - https://github.com/dektrium/yii2-user/blob/master/docs/README.md

Log viewer for laravel-admin (editor Garbuz Ivan)
============================

### Editor Garbuz Ivan
Оригинал пакета https://github.com/laravel-admin-extensions/log-viewer 

Мои правки:
- Исправлена фатальная ошибка в случае отсутствия лог файла
- Добавлена кнопка удаления лог файла

## Screenshot

![wx20170809-165644](https://user-images.githubusercontent.com/1479100/29113581-fe48fd86-7d23-11e7-9ee7-9680957171ee.png)

## Installation

```
$ composer require garbuzivan/log-viewer -vvv

$ php artisan admin:import log-viewer
```

Open `http://localhost/admin/logs`.

License
------------
Author https://github.com/laravel-admin-extensions/log-viewer
Licensed under [The MIT License (MIT)](LICENSE).

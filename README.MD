## Тестовое задание для tapir.ws

Получение и фильтрация списка машин.

#### Установка
```bash
git clone https://github.com/three-cos/tapir-test.git 
cd tapir-test
docker-compose up
```

#### Пример использования
```php
<?php

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Warden\CarAPI\CarStockAPI;
use Warden\CarAPI\Response\JsonResponse;
use Warden\CarAPI\Storage\FileStorage;

include_once 'vendor/autoload.php';

// Инициализация
$api = new CarStockAPI(
    new Client(),
    new Request('GET', $_SERVER['REQUEST_URI']),
    new FileStorage(__DIR__ . '/files')
);

$api->setSource('new_cars.json') // получение данных
    ->setSource('used_cars.xml')
    ->filter() // фильтрация на основе get запроса
    ->paginate(10) // пагинация
    ->response(new JsonResponse()); // возврат ответа
```

#### Фильтрация
Формируется из GET запроса на основе постфиксов параметра.
Например:
`localhost/?brand_is=Kia&price_less=1000000` вернет отфильтрованные машины Kia с ценой меньше миллиона.

Параметры через нижнее подчеркивание должны быть переданы через camelCase

```php
engineType=Газ // Верно
engine_type=Газ // Ошибка
```

##### Доступные постфиксы
```php
<param>|<param>_is // brand=Kia OR brand_is=Kia точное соответствие
<param>_in // brand_in=Kia|Mercedes присутствие в массиве
<param>_from|<param>_greater // price_from=10000 OR price_greater=10000 значение больше параметра
<param>_to|<param>_less // price_to=20000 OR price_less=20000 значение меньше параметра
```

#### Пагинация
Используется через GET параметр `page`

```php
localhost/?brand=Kia&page=10
```

#### Хранение данных 
```php
Warden\CarAPI\Storage\FileStorage // файловое хранилище
Warden\CarAPI\Storage\RedisStorage // в Redis
Warden\CarAPI\Storage\MemcachedStorage // в Memcached
```

#### Возврат данных
```php
Warden\CarAPI\Response\JsonResponse // в формате JSON
Warden\CarAPI\Response\XmlResponse // в формате XML
```

#### Тестиривание
```bash
/vendor/bin/phpunit/ tests
```
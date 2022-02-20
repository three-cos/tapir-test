<?php

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Warden\CarAPI\CarStockAPI;
use Warden\CarAPI\Response\JsonResponse;
use Warden\CarAPI\Response\XmlResponse;
use Warden\CarAPI\Storage\FileStorage;
use Warden\CarAPI\Storage\RedisStorage;
use Warden\CarAPI\Storage\MemcachedStorage;

include_once 'vendor/autoload.php';

$api = new CarStockAPI(
    new Client(),
    new Request('GET', $_SERVER['REQUEST_URI']),
    new FileStorage(__DIR__ . '/files')
);
// $api = new CarStockAPI(new Client(), new Request('GET', $_SERVER['REQUEST_URI']), new MemcachedStorage('memcached', 11211));
// $api = new CarStockAPI(new Client(), new Request('GET', $_SERVER['REQUEST_URI']), new RedisStorage(['host' => 'redis', 'port' => 6379]));

$api->setSource('new_cars.json')
    ->setSource('used_cars.xml')
    ->filter()
    ->paginate(10)
    ->response(new JsonResponse());

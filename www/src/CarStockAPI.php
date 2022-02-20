<?php

namespace Warden\CarAPI;

use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Warden\CarAPI\Filter\Filter;
use Warden\CarAPI\Response\Response;
use Warden\CarAPI\Storage\Storage;

class CarStockAPI
{
    protected array $sources = [];
    protected array $filtered = [];
    protected array $query = [];
    protected int $items_per_page = 5;
    protected ClientInterface $http;
    protected Storage $storage;

    const END_POINT = 'http://static.tapir.ws';

    /**
     * @param  Psr\Http\Client\ClientInterface $http_client
     * @param  Psr\Http\Message\RequestInterface $request
     * @param  Warden\CarAPI\Storage\Storage $storage
     * @return void
     */
    public function __construct(ClientInterface $http_client, RequestInterface $request, Storage $storage)
    {
        $this->http = $http_client;
        $this->storage = $storage;

        parse_str($request->getUri()->getQuery(), $this->query);
    }

    /**
     * Добавляет источник данных
     *
     * @param  string $source
     * @return self
     */
    public function setSource(string $source): self
    {
        $this->sources[] = $source;

        if (!$this->storage->has($source)) {
            $data = $this->download($source);

            $this->storage->store($source, $data);
        }

        return $this;
    }

    /**
     * Фильтрация
     *
     * @return self
     */
    public function filter(): self
    {
        $this->filtered = $this->combineSources();

        $filter_queries = $this->query;
        unset($filter_queries['page']);

        foreach ($filter_queries as $signature => $value) {
            $filter = Filter::create($signature, $value);

            $this->filtered = $filter->filter($this->filtered);
        }

        return $this;
    }

    /**
     * Установка пагинации
     *
     * @param  int $items_per_page
     * @return self
     */
    public function paginate(int $items_per_page = 5): self
    {
        $this->items_per_page = $items_per_page;

        return $this;
    }

    /**
     * Применение пагинации
     *
     * @return void
     */
    protected function applyPagination(): void
    {
        $this->paginated = $this->filtered;
        $this->page = $this->query['page'] ? $this->query['page'] : 1;

        if (count($this->filtered) > $this->items_per_page) {
            $offset = $this->page * $this->items_per_page;

            $this->paginated = array_slice($this->filtered, $offset, $this->items_per_page);
        }
    }

    /**
     * Возврат ответа
     *
     * @param  Warden\CarAPI\Response $responseType
     * @return void
     */
    public function response(Response $responseType): void
    {
        $responseType->setHeaders();
        $responseType->setBody($this->getResponse());
    }

    /**
     * Формирование данных для ответа
     *
     * @return void
     */
    protected function getResponse()
    {
        $this->applyPagination();

        $response = [
            'result' => $this->paginated,
            'total' => count($this->filtered),
            'page' => (int) $this->page,
        ];

        return $response;
    }

    /**
     * Объединение источников данных в один массив
     *
     * @return array
     */
    protected function combineSources(): array
    {
        $items = [];

        foreach ($this->sources as $file) {
            $data = $this->storage->get($file);
            $items = array_merge($items, $data);
        }

        return $items;
    }

    /**
     * Запрос на сервер
     *
     * @param  string $source
     * @return string
     */
    protected function download(string $source): string
    {
        $response = $this->http->get(self::END_POINT . '/' . $source);

        $body = $response->getBody();

        return $body->getContents();
    }
}

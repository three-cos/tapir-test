<?php

namespace Warden\CarAPI\Storage;

use Predis\Client;
use Warden\CarAPI\Parser\Parser;

class RedisStorage implements Storage
{
    protected $client;

    public function __construct(array $dsn)
    {
        $this->client = new Client($dsn);
    }

    /**
     * @inheritdoc
     */
    public function store(string $key, string $data): bool
    {
        return $this->client->set($key, $data, $this->ttl()) !== null;
    }

    /**
     * @inheritdoc
     */
    public function has(string $key): bool
    {
        return $this->client->get($key) !== null;
    }

    /**
     * @inheritdoc
     */
    public function get(string $key): array
    {
        $array_data = Parser::parse($key, $this->client->get($key));

        return $array_data;
    }

    /**
     * @inheritdoc
     */
    public function ttl(): int
    {
        return time() + 1 * 60 * 60; // one hour
    }
}

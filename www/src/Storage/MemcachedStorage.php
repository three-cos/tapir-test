<?php

namespace Warden\CarAPI\Storage;

use Warden\CarAPI\Parser\Parser;
use \Memcached;

class MemcachedStorage implements Storage
{
    protected $client;

    public function __construct(string $host, int $port = 11211)
    {
        $this->client = new Memcached();
        $this->client->addServer($host, $port);
    }

    /**
     * @inheritdoc
     */
    public function store(string $key, string $data): bool
    {
        return $this->client->add($key, $data, $this->ttl());
    }

    /**
     * @inheritdoc
     */
    public function has(string $key): bool
    {
        return $this->client->get($key) !== false;
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

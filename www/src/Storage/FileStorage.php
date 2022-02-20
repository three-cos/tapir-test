<?php

namespace Warden\CarAPI\Storage;

use Warden\CarAPI\Parser\Parser;

class FileStorage implements Storage
{
    public function __construct(string $storage_path)
    {
        if (!is_dir($storage_path)) {
            mkdir($storage_path, 0755);
        }

        $this->path = $storage_path;
    }

    /**
     * @inheritdoc
     */
    public function store(string $file, string $data): bool
    {
        return file_put_contents($this->path . '/' . $file, $data) !== false;
    }

    /**
     * @inheritdoc
     */
    public function has(string $file): bool
    {
        return file_exists($this->path . '/' . $file) && !$this->needUpdate($file);
    }

    /**
     * @inheritdoc
     */
    public function get(string $file): array
    {
        $plain_data = @file_get_contents($this->path . '/' . $file);

        $array_data = Parser::parse($file, $plain_data);

        return $array_data;
    }

    /**
     * Нужно ли обновить файлы?
     *
     * @param  string $file
     * @return bool
     */
    public function needUpdate(string $file): bool
    {
        return (filemtime($this->path . '/' . $file) + $this->ttl()) < time();
    }

    /**
     * @inheritdoc
     */
    public function ttl(): int
    {
        return 1 * 60 * 60; // one hour
    }
}

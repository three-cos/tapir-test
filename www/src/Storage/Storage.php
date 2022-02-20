<?php

namespace Warden\CarAPI\Storage;

interface Storage
{
    /**
     * Сохранение данных
     *
     * @param  mixed $key
     * @param  mixed $data
     * @return bool
     */
    public function store(string $key, string $data): bool;

    /**
     * Проверка наличия данных
     *
     * @param  mixed $key
     * @return bool
     */
    public function has(string $key): bool;

    /**
     * Получение данных
     *
     * @param  mixed $key
     * @return array
     */
    public function get(string $key): array;

    /**
     * Получение времени устаревания данных
     *
     * @return int
     */
    public function ttl(): int;
}

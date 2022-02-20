<?php

namespace Warden\CarAPI\Filter;

abstract class Filter
{
    protected string $key;
    protected $value;

    public function __construct(string $key, $value = null)
    {
        $this->key = $key;
        $this->value = $value;
    }

    /**
     * Фильтрация
     *
     * @param  array $items
     * @return array
     */
    abstract public function filter(array $items): array;

    abstract public static function match(string $signature): bool;

    /**
     * Фабрика фильтров на основе GET параметра
     *
     * @param  string $signature
     * @param  mixed $value
     * @return Warden\CarAPI\Filter
     */
    public static function create(string $signature, $value): Filter
    {
        [$property, $type] = explode('_', $signature);

        $property = toSnakeCase($property);

        $property = strtolower($property);

        $value = urldecode($value);

        $available_filters = [
            LikeFilter::class,
            FromFilter::class,
            ToFilter::class,
            MatchFilter::class,
            IsFilter::class,
        ];

        foreach ($available_filters as $filter_class) {
            if ($filter_class::match($signature)) {
                return new $filter_class($property, $value);
            }
        }
    }
}

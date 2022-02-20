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

    /**
     * Фабрика фильтров на основе GET параметра
     *
     * @param  string $signature
     * @param  mixed $value
     * @return Warden\CarAPI\Filter
     */
    static public function create(string $signature, $value): Filter
    {
        [$property, $type] = explode('_', $signature);

        $property = toSnakeCase($property);

        $property = strtolower($property);

        $value = urldecode($value);

        switch ($type) {
            case 'to':
            case 'less':
                $filter = new ToFilter($property, $value);
                break;

            case 'from':
            case 'greater':
                $filter = new FromFilter($property, $value);
                break;

                // case 'is':
                // $filter = new PresentFilter($property, $value);
                // break;

            case 'in':
                $filter = new MatchFilter($property, $value);
                break;

            default:
                $filter = new IsFilter($property, $value);
        }

        return $filter;
    }
}

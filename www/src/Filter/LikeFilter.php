<?php

namespace Warden\CarAPI\Filter;

class LikeFilter extends Filter
{
    /**
     * @inheritdoc
     */
    public function filter(array $items): array
    {
        return array_reduce($items, function ($result, $item) {
            $expected = mb_strtolower($item[$this->key]);
            $actual = mb_strtolower($this->value);

            if (strpos($expected, $actual) !== false) {
                $result[] = $item;
            }

            return $result;
        }, []);
    }

    public static function match(string $signature): bool
    {
        return preg_match('/(\w*)_like$/', $signature) !== 0;
    }
}

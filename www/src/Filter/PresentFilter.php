<?php

namespace Warden\CarAPI\Filter;

class PresentFilter extends Filter
{
    /**
     * @inheritdoc
     */
    public function filter(array $items): array
    {
        return array_reduce($items, function ($result, $item) {
            if (!empty($item[$this->key])) {
                $result[] = $item;
            }

            return $result;
        }, []);
    }

    public static function match(string $signature): bool
    {
        return true;
    }
}

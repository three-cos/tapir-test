<?php

namespace Warden\CarAPI\Filter;

class FromFilter extends Filter
{
    /**
     * @inheritdoc
     */
    public function filter(array $items): array
    {
        return array_reduce($items, function ($result, $item) {
            if ($item[$this->key] >= $this->value) {
                $result[] = $item;
            }

            return $result;
        }, []);
    }

    public static function match(string $signature): bool
    {
        return preg_match('/(\w*)_(from|greater)$/', $signature) !== 0;
    }
}

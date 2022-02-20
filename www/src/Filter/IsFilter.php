<?php

namespace Warden\CarAPI\Filter;

class IsFilter extends Filter
{
    /**
     * @inheritdoc
     */
    public function filter(array $items): array
    {
        return array_reduce($items, function ($result, $item) {
            if ($item[$this->key] == $this->value) {
                $result[] = $item;
            }

            return $result;
        }, []);
    }
}

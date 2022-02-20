<?php

namespace Warden\CarAPI\Filter;

class MatchFilter extends Filter
{
    /**
     * @inheritdoc
     */
    public function filter(array $items): array
    {
        $possible_values = explode('|', $this->value);

        return array_reduce($items, function ($result, $item) use ($possible_values) {
            if (in_array($item[$this->key], $possible_values)) {
                $result[] = $item;
            }

            return $result;
        }, []);
    }
}

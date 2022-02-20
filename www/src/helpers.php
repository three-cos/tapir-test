<?php

if (!function_exists('toSnakeCase')) {
    /**
     * toSnakeCase => to_snake_case
     *
     * @param  string $string
     * @return string
     */
    function toSnakeCase(string $string): string
    {
        $string[0] = strtolower($string[0]);
        $string = preg_replace('/([A-Z])/', '_$1', $string);
        $snake_string = strtolower($string);

        return $snake_string;
    }
}

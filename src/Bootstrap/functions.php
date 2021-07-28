<?php

if (function_exists('array_rand_value') === false) {
    function array_rand_value(array $data): mixed
    {
        if (empty($data)) {
            return null;
        }

        return $data[array_rand($data)];
    }
}
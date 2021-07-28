<?php

use Symfony\Component\Dotenv\Dotenv;

(new Dotenv())->load(dirname(__DIR__, 2) . '/.env');

if (function_exists('env') === false) {
    function env(string $key): mixed
    {
        if (isset($_ENV[$key])) {
            return $_ENV[$key];
        }

        return null;
    }
}
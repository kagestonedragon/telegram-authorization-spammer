<?php

return [
    'console' => [
        'name' => 'console',
        'streams' => [
            'php://stdout'
        ],
        'formatter' => [
            'output' => '[%datetime%] [%channel%] %level_name%: %message%' . PHP_EOL,
            'datetime' => 'Y:m:d h:i:s',
        ],
    ],
    'telegram' => [
        'name' => 'authorization-logger',
        'streams' => [
            'php://stdout',
            dirname(__DIR__) . '/logs/telegram.log',
        ],
        'formatter' => [
            'output' => '[%datetime%] [%channel%] %level_name%: %message%' . PHP_EOL,
            'datetime' => 'Y:m:d h:i:s',
        ],
    ],
];
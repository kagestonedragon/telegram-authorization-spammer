<?php

return [
    'url' => 'https://oauth.telegram.org/auth/request',
    'bot' => [
        'id' => env('TELEGRAM_BOT_ID'),
        'domain' => env('TELEGRAM_BOT_DOMAIN'),
    ],
    'command' => [
        'sleep' => 5000,
    ],
];
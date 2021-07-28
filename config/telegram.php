<?php

return [
    'url' => 'https://oauth.telegram.org/auth/request',
    'bot' => [
        'id' => env('TELEGRAM_BOT_ID'),
        'domain' => env('TELEGRAM_BOT_DOMAIN'),
    ],
    'command' => [
        'sleep' => 3000000,
        'default_phones_list' => dirname(__DIR__) . '/resources/phones_list',
        'default_user_agents_list' => dirname(__DIR__) . '/resources/user_agents_list',
        'default_proxies_list' => dirname(__DIR__) . '/resources/proxies_list',
    ],
];
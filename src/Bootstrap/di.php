<?php

use Kagestonedragon\TelegramAuthorizationSpammer\Utils\Di;
use Kagestonedragon\TelegramAuthorizationSpammer\Providers;

/** @var Providers\ProviderInterface[] $providers */
$providers = [
    new Providers\Repositories\ConfigurationRepositoryProvider(),
    new Providers\Services\Telegram\AuthorizationServiceProvider(),
    new Providers\Formatters\PhoneFormattersProvider(),
];

$di = Di::getInstance();

foreach ($providers as $provider) {
    $di->set($provider::getId(), $provider->getService($di));
}

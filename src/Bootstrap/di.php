<?php

use Kagestonedragon\TelegramAuthorizationSpammer\Utils\Di\Manager;
use Kagestonedragon\TelegramAuthorizationSpammer\Providers;

/** @var Providers\ProviderInterface[] $providers */
$providers = [
    new Providers\Repositories\ConfigurationRepositoryProvider(),
    new Providers\Services\Telegram\AuthorizationServiceProvider(),
    new Providers\Formatters\PhoneFormattersProvider(),
    new Providers\Factories\LoggersFactoryProvider(),
    new Providers\Factories\ReadersFactoryProvider(),
];

$di = Manager::getInstance();

foreach ($providers as $provider) {
    $di->set($provider::getId(), $provider->getService($di));
}

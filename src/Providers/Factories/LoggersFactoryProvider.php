<?php

namespace Kagestonedragon\TelegramAuthorizationSpammer\Providers\Factories;

use Kagestonedragon\TelegramAuthorizationSpammer\Factories\LoggersFactory;
use Kagestonedragon\TelegramAuthorizationSpammer\Providers\AbstractProvider;
use Kagestonedragon\TelegramAuthorizationSpammer\Providers\Repositories\ConfigurationRepositoryProvider;
use Kagestonedragon\TelegramAuthorizationSpammer\Repositories\ConfigurationRepositoryInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoggersFactoryProvider extends AbstractProvider
{
    public function getService(ContainerInterface $container): object
    {
        /** @var ConfigurationRepositoryInterface $configurationRepository */
        $configurationRepository = $container->get(ConfigurationRepositoryProvider::getId());

        return new LoggersFactory($configurationRepository);
    }
}
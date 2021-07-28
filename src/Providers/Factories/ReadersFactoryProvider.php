<?php

namespace Kagestonedragon\TelegramAuthorizationSpammer\Providers\Factories;

use Kagestonedragon\TelegramAuthorizationSpammer\Factories\ReadersFactory;
use Kagestonedragon\TelegramAuthorizationSpammer\Providers\AbstractProvider;
use Kagestonedragon\TelegramAuthorizationSpammer\Utils\Di\ContainerInterface;

/**
 * Class ReadersFactoryProvider
 * @package Kagestonedragon\TelegramAuthorizationSpammer\Providers\Factories
 */
class ReadersFactoryProvider extends AbstractProvider
{
    /**
     * @param ContainerInterface $container
     * @return object
     */
    public function getService(ContainerInterface $container): object
    {
        return new ReadersFactory();
    }
}
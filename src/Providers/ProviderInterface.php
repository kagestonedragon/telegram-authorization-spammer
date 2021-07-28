<?php

namespace Kagestonedragon\TelegramAuthorizationSpammer\Providers;

use Kagestonedragon\TelegramAuthorizationSpammer\Utils\Di\ContainerInterface;

/**
 * Interface ProviderInterface
 * @package Kagestonedragon\TelegramAuthorizationSpammer\Providers
 */
interface ProviderInterface
{
    /**
     * @param ContainerInterface $container
     * @return object
     */
    public function getService(ContainerInterface $container): object;

    /**
     * @return string
     */
    public static function getId(): string;
}

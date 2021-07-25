<?php

namespace Kagestonedragon\TelegramAuthorizationSpammer\Providers;

/**
 * Class AbstractProvider
 * @package Kagestonedragon\TelegramAuthorizationSpammer\Providers
 */
abstract class AbstractProvider implements ProviderInterface
{
    /**
     * @return string
     */
    public static function getId(): string
    {
        return static::class;
    }
}
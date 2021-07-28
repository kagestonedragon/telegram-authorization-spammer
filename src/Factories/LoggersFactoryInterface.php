<?php

namespace Kagestonedragon\TelegramAuthorizationSpammer\Factories;

use Kagestonedragon\TelegramAuthorizationSpammer\Utils\Loggers\LoggerInterface;

/**
 * Interface LoggersFactoryInterface
 * @package Kagestonedragon\TelegramAuthorizationSpammer\Factories
 */
interface LoggersFactoryInterface
{
    /**
     * @param string $name
     * @return LoggerInterface
     */
    public function create(string $name): LoggerInterface;
}
<?php

namespace Kagestonedragon\TelegramAuthorizationSpammer\Utils\Loggers;

use Psr\Log\LoggerInterface as BaseLoggerInterface;
use Psr\Log\LogLevel;

/**
 * Interface LoggerInterface
 * @package Kagestonedragon\TelegramAuthorizationSpammer\Utils\Loggers
 */
interface LoggerInterface extends BaseLoggerInterface
{
    /**
     * @param \Throwable $t
     * @param string $level
     */
    public function logException(\Throwable $t, string $level = LogLevel::CRITICAL): void;
}
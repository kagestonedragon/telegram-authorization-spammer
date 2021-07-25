<?php

namespace Kagestonedragon\TelegramAuthorizationSpammer\Utils;

use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;

/**
 * Class LoggerHelper
 * @package Kagestonedragon\TelegramAuthorizationSpammer\Utils
 */
final class LoggerHelper
{
    /**
     * @param LoggerInterface $logger
     * @param \Throwable $t
     * @param string $level
     */
    public static function logException(LoggerInterface $logger, \Throwable $t, string $level = LogLevel::CRITICAL,): void
    {
        $message = sprintf(
            "%s: %s. %s",
            $t::class,
            $t->getMessage(),
            $t->getTraceAsString()
        );

        $logger->log($level, $message);
    }
}
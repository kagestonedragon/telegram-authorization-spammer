<?php

namespace Kagestonedragon\TelegramAuthorizationSpammer\Utils\Loggers;

use Monolog\Logger as BaseLogger;
use Psr\Log\LogLevel;

/**
 * Class Logger
 * @package Kagestonedragon\TelegramAuthorizationSpammer\Utils\Loggers
 */
class Logger extends BaseLogger implements LoggerInterface
{
    /**
     * @param \Throwable $t
     * @param string $level
     */
    public function logException(\Throwable $t, string $level = LogLevel::CRITICAL): void
    {
        $this->log($level, sprintf(
            "%s: %s. %s",
            $t::class,
            $t->getMessage(),
            $t->getTraceAsString()
        ));
    }
}
<?php

namespace Kagestonedragon\TelegramAuthorizationSpammer\Formatters;

/**
 * Interface FormatterInterface
 * @package Kagestonedragon\TelegramAuthorizationSpammer\Formatters
 */
interface FormatterInterface
{
    /**
     * @param mixed $value
     * @return mixed
     */
    public function format(mixed $value): mixed;
}
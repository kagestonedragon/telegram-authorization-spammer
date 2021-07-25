<?php

namespace Kagestonedragon\TelegramAuthorizationSpammer\Formatters;

/**
 * TODO вынести форматтеры в отдельный пакет
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
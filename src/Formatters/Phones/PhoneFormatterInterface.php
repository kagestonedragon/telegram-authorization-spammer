<?php

namespace Kagestonedragon\TelegramAuthorizationSpammer\Formatters\Phones;

use Kagestonedragon\TelegramAuthorizationSpammer\Formatters\FormatterInterface;

/**
 * Interface PhoneFormatterInterface
 * @package Kagestonedragon\TelegramAuthorizationSpammer\Formatters\Phones
 */
interface PhoneFormatterInterface extends FormatterInterface
{
    /**
     * @return string
     */
    public static function getCountryCode(): string;
}
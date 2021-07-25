<?php

namespace Kagestonedragon\TelegramAuthorizationSpammer\Formatters\Phones;

/**
 * Class DefaultPhoneFormatter
 * @package Kagestonedragon\TelegramAuthorizationSpammer\Formatters\Phones
 */
class PhoneFormatter extends AbstractPhoneFormatter
{
    /**
     * @param mixed $value
     * @return string
     */
    public function format(mixed $value): string
    {
        return parent::format($value);
    }

    /**
     * @return int
     */
    public function getMinimalCharacters(): int
    {
        return 0;
    }
}
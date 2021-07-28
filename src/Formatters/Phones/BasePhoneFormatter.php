<?php

namespace Kagestonedragon\TelegramAuthorizationSpammer\Formatters\Phones;

/**
 * Class PhoneFormatter
 * @package Kagestonedragon\TelegramAuthorizationSpammer\Formatters\Phones
 */
class BasePhoneFormatter extends AbstractPhoneFormatter
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
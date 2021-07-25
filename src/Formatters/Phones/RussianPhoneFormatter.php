<?php

namespace Kagestonedragon\TelegramAuthorizationSpammer\Formatters\Phones;

/**
 * Class RuPhoneNumberFormatter
 * @package Kagestonedragon\TelegramAuthorizationSpammer\Formatters\PhoneNumbers
 */
class RussianPhoneFormatter extends AbstractPhoneFormatter
{
    /**
     * +7 (999) 999 99-99 | 8 (999) 999 99-99 -> 79999999999
     *
     * @param mixed $value
     * @return string
     */
    public function format(mixed $value): string
    {
        $value = parent::format($value);

        return '7' . substr($value, -10, 10);
    }

    /**
     * @return int
     */
    protected function getMinimalCharacters(): int
    {
        return 10;
    }

}
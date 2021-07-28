<?php

namespace Kagestonedragon\TelegramAuthorizationSpammer\Formatters\Phones;

/**
 * Class RussianPhoneFormatter
 * @package Kagestonedragon\TelegramAuthorizationSpammer\Formatters\Phones
 */
class RussianPhoneFormatter extends BasePhoneFormatter
{
    protected const PHONE_PATTERN = "7%s";

    /**
     * +7 (999) 999 99-99 | 8 (999) 999 99-99 -> 79999999999
     *
     * @param mixed $value
     * @return string
     */
    public function format(mixed $value): string
    {
        return sprintf(
            static::PHONE_PATTERN,
            $this->getUsefulPiece(parent::format($value))
        );
    }

    /**
     * @param string $value
     * @return string
     */
    protected function getUsefulPiece(string $value): string
    {
        return substr(
            $value,
            $this->getMinimalCharacters() * (-1),
            $this->getMinimalCharacters()
        );
    }

    /**
     * @return int
     */
    protected function getMinimalCharacters(): int
    {
        return 10;
    }

    /**
     * @return string
     */
    public static function getCountryCode(): string
    {
        return 'RU';
    }

}
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

        return implode('', [
            $this->getStartsWith(),
            $this->getUsefullPiece($value)
        ]);
    }

    /**
     * @param string $value
     * @return string
     */
    protected function getUsefullPiece(string $value): string
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
    protected function getStartsWith(): string
    {
        return '7';
    }

}
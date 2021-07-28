<?php

namespace Kagestonedragon\TelegramAuthorizationSpammer\Formatters\Phones;

use Kagestonedragon\TelegramAuthorizationSpammer\Formatters\Exceptions\FormatterException;

/**
 * Class AbstractPhoneFormatter
 * @package Kagestonedragon\TelegramAuthorizationSpammer\Formatters\Phones
 */
class BasePhoneFormatter implements PhoneFormatterInterface
{
    /**
     * @param mixed $value
     * @return string
     */
    public function format(mixed $value): string
    {
        if (empty($value) || is_string($value) === false) {
            throw new FormatterException(sprintf(
                "Given value isn't correct: %s",
                $value
            ));
        }

        $normalizedValue = $this->normalize($value);

        if ($this->validateAfterNormalization($normalizedValue) === false) {
            throw new FormatterException(sprintf(
                "Given value isn't correct after normalization: given %s: normalized %s",
                $value,
                $normalizedValue
            ));
        }

        return $normalizedValue;
    }

    /**
     * @param string $value
     * @return string
     */
    protected function normalize(string $value): string
    {
        $result = [];

        foreach (str_split($value) as $character) {
            if (is_numeric($character) === false) {
                continue;
            }

            $result[] = $character;
        }

        return implode('', $result);
    }

    /**
     * @param string $value
     * @return bool
     */
    protected function validateAfterNormalization(string $value): bool
    {
        if (strlen($value) < $this->getMinimalCharacters()) {
            return false;
        }

        return true;
    }

    /**
     * @return int
     */
    protected function getMinimalCharacters(): int
    {
        return 0;
    }

    /**
     * @return string
     */
    public static function getCountryCode(): string
    {
        return 'default';
    }
}


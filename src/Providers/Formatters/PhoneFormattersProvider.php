<?php

namespace Kagestonedragon\TelegramAuthorizationSpammer\Providers\Formatters;

use Kagestonedragon\TelegramAuthorizationSpammer\Formatters;
use Kagestonedragon\TelegramAuthorizationSpammer\Providers\AbstractProvider;
use Kagestonedragon\TelegramAuthorizationSpammer\Utils\Di\ContainerInterface;
use Kagestonedragon\TelegramAuthorizationSpammer\Utils\Di\Manager;

/**
 * Class PhoneFormattersProvider
 * @package Kagestonedragon\TelegramAuthorizationSpammer\Providers\Formatters
 */
class PhoneFormattersProvider extends AbstractProvider
{
    /**
     * @param ContainerInterface $container
     * @return object
     */
    public function getService(ContainerInterface $container): object
    {
        $phoneFormattersContainer = Manager::createInstance();

        foreach ($this->getMap() as $key => $value) {
            $phoneFormattersContainer->set($key, $value);
        }

        return $phoneFormattersContainer;
    }

    /**
     * @return Formatters\Phones\PhoneFormatterInterface[]
     */
    protected function getMap(): array
    {
        return [
            $this->getDefaultFormatter()::getCountryCode() =>
                $this->getDefaultFormatter(),
            Formatters\Phones\RussianPhoneFormatter::getCountryCode() =>
                new Formatters\Phones\RussianPhoneFormatter(),
        ];
    }

    /**
     * @return Formatters\Phones\PhoneFormatterInterface
     */
    public static function getDefaultFormatter(): Formatters\Phones\PhoneFormatterInterface
    {
        static $default;

        if (empty($default)) {
            $default = new Formatters\Phones\BasePhoneFormatter();
        }

        return $default;
    }
}
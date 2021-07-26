<?php

namespace Kagestonedragon\TelegramAuthorizationSpammer\Providers\Formatters;

use Kagestonedragon\TelegramAuthorizationSpammer\Formatters;
use Kagestonedragon\TelegramAuthorizationSpammer\Providers\AbstractProvider;
use Kagestonedragon\TelegramAuthorizationSpammer\Utils\Di;
use League\ISO3166\ISO3166;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class PhoneFormattersProvider
 * @package Kagestonedragon\TelegramAuthorizationSpammer\Providers\Formatters
 */
class PhoneFormattersProvider extends AbstractProvider
{
    public const DEFAULT_FORMATTER_ID = 'default';

    /**
     * @param ContainerInterface $container
     * @return object
     */
    public function getService(ContainerInterface $container): object
    {
        $phoneFormattersContainer = Di::createInstance();

        foreach ($this->getMap() as $key => $value) {
            $phoneFormattersContainer->set($key, $value);
        }

        return $phoneFormattersContainer;
    }

    /**
     * @return Formatters\FormatterInterface[]
     */
    protected function getMap(): array
    {
        $iso = new ISO3166();

        return [
            static::DEFAULT_FORMATTER_ID =>
                new Formatters\Phones\PhoneFormatter(),
            $iso->name('Russian Federation')[$iso::KEY_ALPHA2] =>
                new Formatters\Phones\RussianPhoneFormatter(),
        ];
    }
}
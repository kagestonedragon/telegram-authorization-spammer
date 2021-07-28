<?php

namespace Kagestonedragon\TelegramAuthorizationSpammer\Factories;

use Kagestonedragon\TelegramAuthorizationSpammer\Utils\Files\Reader;
use Kagestonedragon\TelegramAuthorizationSpammer\Utils\Files\ReaderInterface;

/**
 * Class ReaderFactory
 * @package Kagestonedragon\TelegramAuthorizationSpammer\Factories
 */
class ReadersFactory implements ReadersFactoryInterface
{
    /**
     * @param string $file
     * @return ReaderInterface
     * @throws \Kagestonedragon\TelegramAuthorizationSpammer\Utils\Files\Exceptions\ReaderException
     */
    public function create(string $file): ReaderInterface
    {
        return new Reader($file);
    }
}
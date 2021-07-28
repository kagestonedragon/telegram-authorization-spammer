<?php

namespace Kagestonedragon\TelegramAuthorizationSpammer\Factories;

use Kagestonedragon\TelegramAuthorizationSpammer\Utils\Files\ReaderInterface;

/**
 * Interface ReaderFactoryInterface
 * @package Kagestonedragon\TelegramAuthorizationSpammer\Factories
 */
interface ReadersFactoryInterface
{
    /**
     * @param string $file
     * @return ReaderInterface
     */
    public function create(string $file): ReaderInterface;
}
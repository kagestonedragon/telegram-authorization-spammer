<?php

namespace Kagestonedragon\TelegramAuthorizationSpammer\Repositories;

/**
 * Interface ConfigurationRepositoryInterface
 * @package Kagestonedragon\TelegramAuthorizationSpammer\Repositories
 */
interface ConfigurationRepositoryInterface
{
    /**
     * @param string $key
     * @return mixed
     */
    public function get(string $key): mixed;
}
<?php

namespace Kagestonedragon\TelegramAuthorizationSpammer\Repositories;

interface ConfigurationRepositoryInterface
{
    public function get(string $key): mixed;
}
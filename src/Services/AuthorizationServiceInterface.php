<?php

namespace Kagestonedragon\TelegramAuthorizationSpammer\Services;

/**
 * Interface AuthorizationInterface
 * @package Kagestonedragon\TelegramAuthorizationSpammer\Services
 */
interface AuthorizationServiceInterface
{
    public function authorize(string $phone, ?string $userAgent = null): void;
}

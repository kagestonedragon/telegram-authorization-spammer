<?php

namespace Kagestonedragon\TelegramAuthorizationSpammer\Services\Telegram;

/**
 * Interface AuthorizationServiceInterface
 * @package Kagestonedragon\TelegramAuthorizationSpammer\Services\Telegram
 */
interface AuthorizationServiceInterface
{
    public function authorize(string $phone, ?string $userAgent = null): bool;
}

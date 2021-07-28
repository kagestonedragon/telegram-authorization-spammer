<?php

namespace Kagestonedragon\TelegramAuthorizationSpammer\Services\Telegram;

/**
 * Interface AuthorizationServiceInterface
 * @package Kagestonedragon\TelegramAuthorizationSpammer\Services\Telegram
 */
interface AuthorizationServiceInterface
{
    /**
     * @param string $phone
     * @param string|null $userAgent
     * @param string|null $proxy
     * @return bool
     */
    public function authorize(string $phone, ?string $userAgent, ?string $proxy): bool;
}

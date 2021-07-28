<?php

namespace Kagestonedragon\TelegramAuthorizationSpammer\Utils\Files;

interface ReaderInterface
{
    /**
     * @return string|null
     */
    public function getLine(): ?string;

    /**
     * @return string[]
     */
    public function getLinesAsArray(): array;
}
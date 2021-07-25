<?php

namespace Kagestonedragon\TelegramAuthorizationSpammer\Utils\Files;

/**
 * Class Reader
 * @package Kagestonedragon\TelegramAuthorizationSpammer\Utils\Files
 */
final class Reader
{
    /** @var resource $resource */
    private $resource;

    /**
     * Reader constructor.
     * @param string $file
     */
    public function __construct(string $file)
    {
        $this->resource = $this->getResource($file);
    }

    /**
     * @return string|null
     */
    public function getLine(): ?string
    {
        return fgets($this->resource);
    }

    /**
     * @param string $file
     * @return resource
     */
    private function getResource(string $file)
    {
        $resource = fopen($file, 'r');

        if ($resource === false) {
            throw new \RuntimeException(sprintf(
                "%s: cannot open file",
                $file
            ));
        }

        return $resource;
    }
}
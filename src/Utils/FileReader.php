<?php

namespace Kagestonedragon\TelegramAuthorizationSpammer\Utils;

/**
 * Class FileReader
 * @package Kagestonedragon\TelegramAuthorizationSpammer\Utils
 */
final class FileReader
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
     * @return array
     */
    public function getLinesAsArray(): array
    {
        $result = [];

        while ($line = $this->getLine()) {
            $result[] = $line;
        }

        fseek($this->resource, 0, SEEK_SET);

        return $result;
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
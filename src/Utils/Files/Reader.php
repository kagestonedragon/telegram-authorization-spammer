<?php

namespace Kagestonedragon\TelegramAuthorizationSpammer\Utils\Files;

use Kagestonedragon\TelegramAuthorizationSpammer\Utils\Files\Exceptions\ReaderException;

class Reader implements ReaderInterface
{
    /** @var resource $resource */
    private $resource;

    /**
     * Reader constructor.
     * @param string $file
     * @throws ReaderException
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
     * @throws ReaderException
     */
    private function getResource(string $file)
    {
        $resource = fopen($file, 'r');

        if ($resource === false) {
            throw new ReaderException(sprintf(
                "%s: cannot open file",
                $file
            ));
        }

        return $resource;
    }
}
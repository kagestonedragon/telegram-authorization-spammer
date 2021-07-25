<?php

namespace Kagestonedragon\TelegramAuthorizationSpammer\Repositories;

use Kagestonedragon\TelegramAuthorizationSpammer\Repositories\Exceptions\NotFoundException;
use Noodlehaus\Config;

/**
 * Class ConfigurationRepository
 * @package Kagestonedragon\TelegramAuthorizationSpammer\Repository
 */
class ConfigurationRepository implements ConfigurationRepositoryInterface
{
    /** @var Config $config */
    protected Config $config;

    /**
     * ConfigurationRepository constructor.
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function get(string $key): mixed
    {
        $value = $this->config->get($key);

        if ($value === null) {
            throw new NotFoundException(sprintf('Cannot found value with key "%s"', $key));
        }

        return $value;
    }
}
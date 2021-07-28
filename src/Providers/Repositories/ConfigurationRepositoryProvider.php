<?php

namespace Kagestonedragon\TelegramAuthorizationSpammer\Providers\Repositories;

use Kagestonedragon\TelegramAuthorizationSpammer\Providers\AbstractProvider;
use Kagestonedragon\TelegramAuthorizationSpammer\Repositories\ConfigurationRepository;
use Kagestonedragon\TelegramAuthorizationSpammer\Utils\Di\ContainerInterface;
use Noodlehaus\Config;

/**
 * Class ConfigurationRepositoryProvider
 * @package Kagestonedragon\TelegramAuthorizationSpammer\Providers\Repositories
 */
class ConfigurationRepositoryProvider extends AbstractProvider
{
    /**
     * @param ContainerInterface $container
     * @return object
     */
    public function getService(ContainerInterface $container): object
    {
        $config = Config::load(dirname(__DIR__, 3) . '/config/.config.php');

        return new ConfigurationRepository($config);
    }
}
<?php

namespace Kagestonedragon\TelegramAuthorizationSpammer\Providers\Repositories;

use Kagestonedragon\TelegramAuthorizationSpammer\Providers\AbstractProvider;
use Kagestonedragon\TelegramAuthorizationSpammer\Repositories\ConfigurationRepository;
use Noodlehaus\Config;
use Symfony\Component\DependencyInjection\ContainerInterface;

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
<?php

namespace Kagestonedragon\TelegramAuthorizationSpammer\Providers\Services;

use GuzzleHttp\Client as GuzzleClient;
use Kagestonedragon\TelegramAuthorizationSpammer\Providers\AbstractProvider;
use Kagestonedragon\TelegramAuthorizationSpammer\Providers\Repositories\ConfigurationRepositoryProvider;
use Kagestonedragon\TelegramAuthorizationSpammer\Repositories\ConfigurationRepositoryInterface;
use Kagestonedragon\TelegramAuthorizationSpammer\Services\AuthorizationService;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class AuthorizationServiceProvider
 * @package Kagestonedragon\TelegramAuthorizationSpammer\Providers\Services
 */
class AuthorizationServiceProvider extends AbstractProvider
{
    /**
     * @param ContainerInterface $container
     * @return object
     */
    public function getService(ContainerInterface $container): object
    {
        /** @var ConfigurationRepositoryInterface $configurationRepository */
        $configurationRepository = $container->get(ConfigurationRepositoryProvider::getId());

        return new AuthorizationService(
            $configurationRepository,
            new GuzzleClient()
        );
    }
}

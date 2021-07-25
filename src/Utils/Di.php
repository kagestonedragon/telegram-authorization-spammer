<?php

namespace Kagestonedragon\TelegramAuthorizationSpammer\Utils;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class Di
 * @package Kagestonedragon\TelegramAuthorizationSpammer\Utils
 */
final class Di
{
    /** @var ?ContainerInterface $instance */
    private static ?ContainerInterface $instance = null;

    /**
     * @return ContainerInterface
     */
    public static function getInstance(): ContainerInterface
    {
        if (Di::$instance === null) {
            Di::$instance = Di::createInstance();
        }


        return Di::$instance;
    }

    /**
     * @return ContainerInterface
     */
    public static function createInstance(): ContainerInterface
    {
        return new ContainerBuilder();
    }
}
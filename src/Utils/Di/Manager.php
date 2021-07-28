<?php

namespace Kagestonedragon\TelegramAuthorizationSpammer\Utils\Di;

/**
 * Class Di
 * @package Kagestonedragon\TelegramAuthorizationSpammer\Utils\Di
 */
final class Manager
{
    /** @var ?ContainerInterface $instance */
    private static ?ContainerInterface $instance = null;

    /**
     * @return ContainerInterface
     */
    public static function getInstance(): ContainerInterface
    {
        if (Manager::$instance === null) {
            Manager::$instance = Manager::createInstance();
        }


        return Manager::$instance;
    }

    /**
     * @return ContainerInterface
     */
    public static function createInstance(): ContainerInterface
    {
        return new Container();
    }
}
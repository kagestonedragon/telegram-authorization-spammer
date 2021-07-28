<?php

namespace Kagestonedragon\TelegramAuthorizationSpammer\Utils\Di;

use Symfony\Component\DependencyInjection\ContainerInterface as BaseContainerInterface;

interface ContainerInterface extends BaseContainerInterface
{
    /**
     * @param string $id
     * @param int $invalidBehavior
     * @return mixed
     */
    public function get(string $id, int $invalidBehavior = BaseContainerInterface::EXCEPTION_ON_INVALID_REFERENCE): mixed;
}
<?php

namespace Kagestonedragon\TelegramAuthorizationSpammer\Utils\Di;

use Symfony\Component\DependencyInjection\ContainerBuilder as BaseContainerBuilder;
use Symfony\Component\DependencyInjection\ContainerInterface as BaseContainerInterface;

class Container extends BaseContainerBuilder implements ContainerInterface
{
    /**
     * @param string $id
     * @param int $invalidBehavior
     * @return mixed
     * @throws \Exception
     */
    public function get(string $id, int $invalidBehavior = BaseContainerInterface::EXCEPTION_ON_INVALID_REFERENCE): mixed
    {
        return parent::get($id, $invalidBehavior);
    }
}
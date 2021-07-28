<?php

namespace Kagestonedragon\TelegramAuthorizationSpammer\Factories;

use Kagestonedragon\TelegramAuthorizationSpammer\Repositories\ConfigurationRepository;
use Kagestonedragon\TelegramAuthorizationSpammer\Repositories\ConfigurationRepositoryInterface;
use Kagestonedragon\TelegramAuthorizationSpammer\Utils\Loggers\Logger;
use Kagestonedragon\TelegramAuthorizationSpammer\Utils\Loggers\LoggerInterface;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;

/**
 * Class LoggersFactory
 * @package Kagestonedragon\TelegramAuthorizationSpammer\Factories
 */
class LoggersFactory implements LoggersFactoryInterface
{
    /** @var ConfigurationRepositoryInterface $configurationRepository */
    protected ConfigurationRepositoryInterface $configurationRepository;

    /**
     * LoggersFactory constructor.
     * @param ConfigurationRepository $configurationRepository
     */
    public function __construct(ConfigurationRepositoryInterface $configurationRepository)
    {
        $this->configurationRepository = $configurationRepository;
    }

    /**
     * @param string $name
     * @return LoggerInterface
     */
    public function create(string $name): LoggerInterface
    {
        $settings = $this->configurationRepository->get('loggers')[$name];

        $logger = new Logger($settings['name']);

        foreach ($settings['streams'] as $stream) {
            $handler = (new StreamHandler($stream))
                ->setFormatter(new LineFormatter(
                    $settings['formatter']['output'],
                    $settings['formatter']['datetime'],
                ));

            $logger->pushHandler($handler);
        }

        return $logger;
    }
}
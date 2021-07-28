<?php

namespace Kagestonedragon\TelegramAuthorizationSpammer\Console\Commands;

use Kagestonedragon\TelegramAuthorizationSpammer\Factories\LoggersFactoryInterface;
use Kagestonedragon\TelegramAuthorizationSpammer\Providers\Factories\LoggersFactoryProvider;
use Kagestonedragon\TelegramAuthorizationSpammer\Providers\Repositories\ConfigurationRepositoryProvider;
use Kagestonedragon\TelegramAuthorizationSpammer\Repositories\ConfigurationRepositoryInterface;
use Kagestonedragon\TelegramAuthorizationSpammer\Utils\Di\Manager;
use Kagestonedragon\TelegramAuthorizationSpammer\Utils\Loggers\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class AbstractCommand
 * @package Kagestonedragon\TelegramAuthorizationSpammer\Console\Commands
 */
abstract class AbstractCommand extends Command
{
    protected const LOGGER_OPTION_CODE = 'logger';

    /** @var LoggerInterface $logger */
    protected LoggerInterface $logger;

    /** @var ConfigurationRepositoryInterface $configurationRepository */
    protected ConfigurationRepositoryInterface $configurationRepository;

    public function __construct()
    {
        $this->initializeConfigurationRepository();

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->addOption(
                static::LOGGER_OPTION_CODE,
                'l',
                InputOption::VALUE_OPTIONAL,
                'Custom logger',
                $this->getLoggerName()
            );
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $this->initializeLogger($input);
    }

    /**
     * @return $this
     */
    private function initializeConfigurationRepository(): self
    {
        $this->configurationRepository = Manager::getInstance()->get(ConfigurationRepositoryProvider::getId());

        return $this;
    }

    /**
     * @param InputInterface $input
     * @return $this
     */
    private function initializeLogger(InputInterface $input): self
    {
        /** @var LoggersFactoryInterface $loggersFactory */
        $loggersFactory = Manager::getInstance()->get(LoggersFactoryProvider::getId());

        $this->logger = $loggersFactory->create($input->getOption(static::LOGGER_OPTION_CODE));

        return $this;
    }

    /**
     * @return string
     */
    protected function getLoggerName(): string
    {
        return $this->configurationRepository->get('application.default_logger');
    }
}
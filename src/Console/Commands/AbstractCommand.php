<?php

namespace Kagestonedragon\TelegramAuthorizationSpammer\Console\Commands;

use Kagestonedragon\TelegramAuthorizationSpammer\Factories\LoggersFactoryInterface;
use Kagestonedragon\TelegramAuthorizationSpammer\Providers\Factories\LoggersFactoryProvider;
use Kagestonedragon\TelegramAuthorizationSpammer\Repositories\ConfigurationRepositoryInterface;
use Kagestonedragon\TelegramAuthorizationSpammer\Utils\Di;
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

    /**
     * AbstractCommand constructor.
     * @param ConfigurationRepositoryInterface $configurationRepository
     */
    public function __construct(ConfigurationRepositoryInterface $configurationRepository)
    {
        $this->configurationRepository = $configurationRepository;

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
        $this->logger = $this->getLoggerInstance($input->getOption(static::LOGGER_OPTION_CODE));
    }

    /**
     * @param string $name
     * @return LoggerInterface
     */
    private function getLoggerInstance(string $name): LoggerInterface
    {
        /** @var LoggersFactoryInterface $loggersFactory */
        $loggersFactory = Di::getInstance()->get(LoggersFactoryProvider::getId());

        return $loggersFactory->create($name);
    }

    /**
     * @return string
     */
    protected function getLoggerName(): string
    {
        return $this->configurationRepository->get('application.default_logger');
    }
}
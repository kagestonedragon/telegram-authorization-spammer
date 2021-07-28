<?php

namespace Kagestonedragon\TelegramAuthorizationSpammer\Console\Commands;

use Kagestonedragon\TelegramAuthorizationSpammer\Repositories\ConfigurationRepositoryInterface;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Log\LoggerInterface;
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
    protected const LOGGER = 'console';

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
            );
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $this->logger = $this->getLogger($input);
    }

    /**
     * @param InputInterface $input
     * @return LoggerInterface
     */
    private function getLogger(InputInterface $input): LoggerInterface
    {
        $name = $input->getOption(static::LOGGER_OPTION_CODE) ?? static::LOGGER;

        $settings = $this->configurationRepository->get(sprintf("loggers.%s", $name));

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
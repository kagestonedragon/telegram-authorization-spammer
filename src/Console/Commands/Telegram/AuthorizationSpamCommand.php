<?php

namespace Kagestonedragon\TelegramAuthorizationSpammer\Console\Commands\Telegram;

use Kagestonedragon\TelegramAuthorizationSpammer\Console\Commands\AbstractCommand;
use Kagestonedragon\TelegramAuthorizationSpammer\Factories\ReadersFactoryInterface;
use Kagestonedragon\TelegramAuthorizationSpammer\Formatters\Exceptions\FormatterException;
use Kagestonedragon\TelegramAuthorizationSpammer\Formatters\Phones\PhoneFormatterInterface;
use Kagestonedragon\TelegramAuthorizationSpammer\Providers\Factories\ReadersFactoryProvider;
use Kagestonedragon\TelegramAuthorizationSpammer\Providers\Formatters\PhoneFormattersProvider;
use Kagestonedragon\TelegramAuthorizationSpammer\Providers\Services\Telegram\AuthorizationServiceProvider;
use Kagestonedragon\TelegramAuthorizationSpammer\Services\Telegram\AuthorizationServiceInterface;
use Kagestonedragon\TelegramAuthorizationSpammer\Utils\Di\ContainerInterface;
use Kagestonedragon\TelegramAuthorizationSpammer\Utils\Di\Manager;
use Kagestonedragon\TelegramAuthorizationSpammer\Utils\Files\ReaderInterface;
use Psr\Log\LogLevel;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class AuthorizationSpamCommand
 * @package Kagestonedragon\TelegramAuthorizationSpammer\Console\Commands\Telegram
 */
final class AuthorizationSpamCommand extends AbstractCommand
{
    private const PHONES_LIST_OPTION_CODE = 'phones_list';
    private const USER_AGENTS_LIST_OPTION_CODE = 'user_agents_list';
    private const PROXIES_LIST_OPTION_CODE = 'proxies_list';
    private const COUNTRY_CODE_OPTION_CODE = 'country_code';

    /** @var AuthorizationServiceInterface $authorizationService */
    private AuthorizationServiceInterface $authorizationService;

    /** @var PhoneFormatterInterface $phonesFormatter */
    private PhoneFormatterInterface $phonesFormatter;

    /** @var ReaderInterface $phonesReader */
    private ReaderInterface $phonesReader;

    /** @var string[] $userAgents */
    private array $userAgents = [];

    /** @var string[] $proxies */
    private array $proxies = [];

    protected function configure()
    {
        parent::configure();

        $this
            ->setName('telegram:authorization_spammer')
            ->setDescription('Sending authorization messages to users from Telegram with your domain.')
            ->setHelp('https://github.com/kagestonedragon/telegram-authorization-spammer')
            ->addOption(
                self::COUNTRY_CODE_OPTION_CODE,
                'cc',
                InputOption::VALUE_REQUIRED,
                'County code (ISO-3166 Alpha 2)',
                PhoneFormattersProvider::getDefaultFormatter()::getCountryCode()
            )
            ->addOption(
                self::PHONES_LIST_OPTION_CODE,
                'phl',
                InputOption::VALUE_OPTIONAL,
                'Path to file with phones list',
                $this->configurationRepository->get('telegram.command.default_phones_list'),
            )
            ->addOption(
                self::USER_AGENTS_LIST_OPTION_CODE,
                'ual',
                InputOption::VALUE_OPTIONAL,
                'Path to file with user agent list',
                $this->configurationRepository->get('telegram.command.default_user_agents_list'),
            )
            ->addOption(
                self::PROXIES_LIST_OPTION_CODE,
                'prl',
                InputOption::VALUE_OPTIONAL,
                'Path to file with proxies list',
                $this->configurationRepository->get('telegram.command.default_proxies_list'),
            );
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        parent::initialize($input, $output);

        $this->logger->info('Start of initialization');

        $this
            ->initializeAuthorizationService()
            ->initializePhonesFormatter($input)
            ->initializePhonesReader($input)
            ->initializeUserAgents($input)
            ->initializeProxies($input);

        $this->logger->info('End of initialization');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $this->logger->info('Start of executing');

            while ($phone = $this->phonesReader->getLine()) {
                $this->process($phone);

                usleep($this->configurationRepository->get('telegram.command.sleep'));
            }

            $this->logger->info('End of executing');
        } catch (\Throwable $t) {
            $this->logger->logException($t);

            return self::FAILURE;
        }

        return self::SUCCESS;
    }

    /**
     * @param string $phone
     */
    private function process(string $phone): void
    {
        try {
            $this->logger->info(sprintf('Start of processing phone "%s"', $phone));

            $this->authorizationService->authorize(
                $this->phonesFormatter->format($phone),
                $this->getUserAgent(),
                $this->getProxy(),
            );

            $this->logger->info(sprintf('End of processing phone "%s"', $phone));
        } catch (FormatterException $e) {
            $this->logger->logException($e, LogLevel::WARNING);
        }
    }

    /**
     * @return string|null
     */
    private function getUserAgent(): ?string
    {
        return array_rand_value($this->userAgents);
    }

    /**
     * @return string|null
     */
    private function getProxy(): ?string
    {
        return array_rand_value($this->proxies);
    }

    /**
     * @return $this
     */
    private function initializeAuthorizationService(): self
    {
        $this->authorizationService = Manager::getInstance()->get(AuthorizationServiceProvider::getId());

        return $this;
    }

    /**
     * @param InputInterface $input
     * @return $this
     */
    private function initializePhonesFormatter(InputInterface $input): self
    {
        /** @var ContainerInterface $phoneFormattersContainer */
        $phoneFormattersContainer = Manager::getInstance()->get(PhoneFormattersProvider::getId());

        $this->phonesFormatter = $phoneFormattersContainer
            ->get($input->getOption(self::COUNTRY_CODE_OPTION_CODE));

        return $this;
    }

    /**
     * @param InputInterface $input
     * @return $this
     */
    private function initializePhonesReader(InputInterface $input): self
    {
        /** @var ReadersFactoryInterface $readersFactory */
        $readersFactory = Manager::getInstance()->get(ReadersFactoryProvider::getId());

        $this->phonesReader = $readersFactory->create($input->getOption(self::PHONES_LIST_OPTION_CODE));

        return $this;
    }

    /**
     * @param InputInterface $input
     * @return $this
     */
    private function initializeUserAgents(InputInterface $input): self
    {
        /** @var ReadersFactoryInterface $readersFactory */
        $readersFactory = Manager::getInstance()->get(ReadersFactoryProvider::getId());

        $this->userAgents = $readersFactory
            ->create($input->getOption(self::USER_AGENTS_LIST_OPTION_CODE))
            ->getLinesAsArray();

        return $this;
    }

    /**
     * @param InputInterface $input
     * @return $this
     */
    private function initializeProxies(InputInterface $input): self
    {
        /** @var ReadersFactoryInterface $readersFactory */
        $readersFactory = Manager::getInstance()->get(ReadersFactoryProvider::getId());

        $this->proxies = $readersFactory
            ->create($input->getOption(self::PROXIES_LIST_OPTION_CODE))
            ->getLinesAsArray();

        return $this;
    }

    /**
     * @return string
     */
    protected function getLoggerName(): string
    {
        return $this->configurationRepository->get('telegram.command.default_logger');
    }
}
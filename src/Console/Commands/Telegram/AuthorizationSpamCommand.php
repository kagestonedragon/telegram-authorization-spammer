<?php

namespace Kagestonedragon\TelegramAuthorizationSpammer\Console\Commands\Telegram;

use Kagestonedragon\TelegramAuthorizationSpammer\Console\Commands\AbstractCommand;
use Kagestonedragon\TelegramAuthorizationSpammer\Formatters\Exceptions\FormatterException;
use Kagestonedragon\TelegramAuthorizationSpammer\Formatters\FormatterInterface;
use Kagestonedragon\TelegramAuthorizationSpammer\Providers\Formatters\PhoneFormattersProvider;
use Kagestonedragon\TelegramAuthorizationSpammer\Repositories\ConfigurationRepositoryInterface;
use Kagestonedragon\TelegramAuthorizationSpammer\Services\Telegram\AuthorizationServiceInterface;
use Kagestonedragon\TelegramAuthorizationSpammer\Utils\FileReader;
use Kagestonedragon\TelegramAuthorizationSpammer\Utils\LoggerHelper;
use Psr\Log\LogLevel;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class AuthorizationSpamCommand
 * @package Kagestonedragon\TelegramAuthorizationSpammer\Console\Commands\Telegram
 */
final class AuthorizationSpamCommand extends AbstractCommand
{
    protected const LOGGER = 'telegram';

    private const PHONES_LIST_OPTION_CODE = 'phones_list';
    private const USER_AGENTS_LIST_OPTION_CODE = 'user_agents_list';
    private const PROXIES_LIST_OPTION_CODE = 'proxies_list';
    private const COUNTRY_CODE_OPTION_CODE = 'country_code';

    /** @var AuthorizationServiceInterface $authorizationService */
    private AuthorizationServiceInterface $authorizationService;

    /** @var ContainerInterface $phoneFormattersContainer */
    private ContainerInterface $phoneFormattersContainer;

    /** @var FormatterInterface $phoneFormatter */
    private FormatterInterface $phoneFormatter;

    /** @var FileReader $phonesReader */
    private FileReader $phonesReader;

    /** @var string[] $userAgents */
    private array $userAgents = [];

    /** @var string[] $proxies */
    private array $proxies = [];

    /**
     * AuthorizationSpamCommand constructor.
     * @param ConfigurationRepositoryInterface $configurationRepository
     * @param AuthorizationServiceInterface $authorizationService
     * @param ContainerInterface $phoneFormattersContainer
     */
    public function __construct(
        ConfigurationRepositoryInterface $configurationRepository,
        AuthorizationServiceInterface $authorizationService,
        ContainerInterface $phoneFormattersContainer,
    ) {
        $this->authorizationService = $authorizationService;
        $this->phoneFormattersContainer = $phoneFormattersContainer;

        parent::__construct($configurationRepository);
    }

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
                PhoneFormattersProvider::DEFAULT_FORMATTER_ID
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

        /** @var FormatterInterface $phoneFormatter */
        $phoneFormatter = $this->phoneFormattersContainer->get($input->getOption(self::COUNTRY_CODE_OPTION_CODE));

        $this->phoneFormatter = $phoneFormatter;
        $this->phonesReader = new FileReader($input->getOption(self::PHONES_LIST_OPTION_CODE));
        $this->userAgents = (new FileReader($input->getOption(self::USER_AGENTS_LIST_OPTION_CODE)))->getLinesAsArray();
        $this->proxies = (new FileReader($input->getOption(self::PROXIES_LIST_OPTION_CODE)))->getLinesAsArray();

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
            LoggerHelper::logException($this->logger, $t);

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

            $normalizedPhone = $this->phoneFormatter->format($phone);

            $this->logger->info(sprintf('Normalized phone is "%s"', $normalizedPhone));

            $this->logger->info('Authorization attempt');

            $this->authorizationService->authorize(
                $normalizedPhone,
                $this->getUserAgent(),
                $this->getProxy(),
            );

            $this->logger->info('Success authorization');

            $this->logger->info(sprintf('End of processing phone "%s"', $phone));
        } catch (FormatterException $e) {
            LoggerHelper::logException($this->logger, $e, LogLevel::WARNING);
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
}
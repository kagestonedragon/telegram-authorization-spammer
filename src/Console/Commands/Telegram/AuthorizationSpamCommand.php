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
use Symfony\Component\Console\Exception\InvalidOptionException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;

/**
 * Class AuthorizationSpamCommand
 * @package Kagestonedragon\TelegramAuthorizationSpammer\Console\Commands\Telegram
 */
class AuthorizationSpamCommand extends AbstractCommand
{
    protected const LOGGER = 'telegram';

    /** @var AuthorizationServiceInterface $authorizationService */
    protected AuthorizationServiceInterface $authorizationService;

    /** @var ContainerInterface $phoneFormattersContainer */
    protected ContainerInterface $phoneFormattersContainer;

    /** @var FormatterInterface $phoneFormatter */
    protected FormatterInterface $phoneFormatter;

    /** @var FileReader $phonesReader */
    protected FileReader $phonesReader;

    /**
     * AuthorizationCommand constructor.
     * @param ConfigurationRepositoryInterface $configurationRepository
     * @param AuthorizationServiceInterface $authorizationService
     * @param ContainerInterface $phoneFormattersContainer
     */
    public function __construct(
        ConfigurationRepositoryInterface $configurationRepository,
        AuthorizationServiceInterface $authorizationService,
        ContainerInterface $phoneFormattersContainer,
    ) {
        parent::__construct($configurationRepository);

        $this->authorizationService = $authorizationService;
        $this->phoneFormattersContainer = $phoneFormattersContainer;
    }

    protected function configure()
    {
        $this
            ->setName('telegram:authorization_spam')
            ->setDescription('Spam')
            ->setHelp('https://github.com/kagestonedragon/telegram-authorization-spammer')
            ->addOption(
                'country',
                'c',
                InputOption::VALUE_REQUIRED,
                'County code (ISO-3166 Alpha 2)',
            )
            ->addOption(
                'phones',
                'p',
                InputOption::VALUE_REQUIRED,
                'Path to file with phones list'
            )
            ->addOption(
                'user_agents',
                'ua',
                InputOption::VALUE_OPTIONAL,
                'Path to file with user agent list'
            )
            ->addOption(
                'logger',
                'l',
                InputOption::VALUE_OPTIONAL,
                'Custom logger'
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

        $this->phoneFormatter = $this->getPhoneFormatter($input);
        $this->phonesReader = $this->getPhonesReader($input);

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

            return static::FAILURE;
        }

        return static::SUCCESS;
    }

    /**
     * @param string $phone
     */
    protected function process(string $phone): void
    {
        try {
            $this->logger->info(sprintf('Start of processing phone "%s"', $phone));

            $normalizedPhone = $this->phoneFormatter->format($phone);

            $this->logger->info(sprintf('Normalized phone is "%s"', $normalizedPhone));

            $this->logger->info('Authorization attempt');

            $this->authorizationService->authorize($normalizedPhone, $this->getRandomUserAgent());

            $this->logger->info('Success authorization');

            $this->logger->info(sprintf('End of processing phone "%s"', $phone));
        } catch (FormatterException $e) {
            LoggerHelper::logException($this->logger, $e, LogLevel::WARNING);
        }
    }

    /**
     * TODO
     * @return string|null
     */
    private function getRandomUserAgent(): ?string
    {
        return null;
    }

    /**
     * @param InputInterface $input
     * @return FormatterInterface
     */
    private function getPhoneFormatter(InputInterface $input): FormatterInterface
    {
        try {
            $value = $input->getOption('country');

            if (empty($value)) {
                throw new ServiceNotFoundException(PhoneFormattersProvider::getId());
            }

            /** @var FormatterInterface $formatter */
            $formatter = $this->phoneFormattersContainer->get($value);
        } catch (ServiceNotFoundException) {
            $formatter = $this->phoneFormattersContainer->get(PhoneFormattersProvider::DEFAULT_FORMATTER_ID);
        }

        $this->logger->info(sprintf('Formatting phones with "%s"', $formatter::class));

        return $formatter;
    }

    /**
     * @param InputInterface $input
     * @return FileReader
     */
    private function getPhonesReader(InputInterface $input): FileReader
    {
        $value = $input->getOption('phones');

        if (empty($value)) {
            throw new InvalidOptionException('Invalid option value "phones"');
        }

        $reader = new FileReader($value);

        $this->logger->info(sprintf('Reading phones from "%s"', $value));

        return $reader;
    }
}
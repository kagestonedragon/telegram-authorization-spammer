<?php

namespace Kagestonedragon\TelegramAuthorizationSpammer\Services\Telegram;

use GuzzleHttp\Client as GuzzleClient;
use Kagestonedragon\TelegramAuthorizationSpammer\Repositories\ConfigurationRepositoryInterface;
use Kagestonedragon\TelegramAuthorizationSpammer\Exceptions\RuntimeException;

/**
 * Class AuthorizationService
 * @package Kagestonedragon\TelegramAuthorizationSpammer\Services\Telegram
 */
class AuthorizationService implements AuthorizationServiceInterface
{
    /** @var ConfigurationRepositoryInterface $configurationRepository */
    protected ConfigurationRepositoryInterface $configurationRepository;

    /** @var GuzzleClient $guzzleClient */
    protected GuzzleClient $guzzleClient;

    /**
     * AuthorizationService constructor.
     * @param ConfigurationRepositoryInterface $configurationRepository
     * @param GuzzleClient $guzzleClient
     */
    public function __construct(
        ConfigurationRepositoryInterface $configurationRepository,
        GuzzleClient $guzzleClient,
    ) {
        $this->configurationRepository = $configurationRepository;
        $this->guzzleClient = $guzzleClient;
    }

    /**
     * @param string $phone
     * @param string|null $userAgent
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function authorize(string $phone, ?string $userAgent = null): bool
    {
        $response = $this->guzzleClient->post(
            $this->configurationRepository->get('telegram.url'),
            $this->getRequestOptions($phone, $userAgent)
        );

        if ($response->getStatusCode() !== 200) {
            throw new RuntimeException(sprintf('Telegram returned "%s" code', $response->getStatusCode()));
        }

        $body = $response->getBody()->getContents();

        if ($body !== 'true') {
            throw new RuntimeException(sprintf('Telegram returned "%s" body', $body));
        }

        return true;
    }

    /**
     * @param string $phone
     * @param string|null $userAgent
     * @return array
     */
    protected function getRequestOptions(string $phone, ?string $userAgent = null): array
    {
        $options = [
            'query' => [
                'bot_id' => $this->configurationRepository->get('telegram.bot.id'),
                'origin' => $this->configurationRepository->get('telegram.bot.domain'),
                'embed' => 1,
                'request_access' => 'write',
            ],
            'form_params' => [
                'phone' => $phone,
            ],
        ];

        if (!empty($userAgent)) {
            $options['headers']['User-Agent'] = $userAgent;
        }

        return $options;
    }
}

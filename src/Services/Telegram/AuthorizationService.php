<?php

namespace Kagestonedragon\TelegramAuthorizationSpammer\Services\Telegram;

use GuzzleHttp;
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

    /** @var GuzzleHttp\Client $guzzleClient */
    protected GuzzleHttp\Client $guzzleClient;

    /**
     * AuthorizationService constructor.
     * @param ConfigurationRepositoryInterface $configurationRepository
     * @param GuzzleHttp\Client $guzzleClient
     */
    public function __construct(
        ConfigurationRepositoryInterface $configurationRepository,
        GuzzleHttp\Client $guzzleClient,
    ) {
        $this->configurationRepository = $configurationRepository;
        $this->guzzleClient = $guzzleClient;
    }

    /**
     * @param string $phone
     * @param string|null $userAgent
     * @param string|null $proxy
     * @return bool
     * @throws GuzzleHttp\Exception\GuzzleException
     */
    public function authorize(string $phone, ?string $userAgent, ?string $proxy): bool
    {
        $response = $this->guzzleClient->post(
            $this->configurationRepository->get('telegram.url'),
            $this->getRequestOptions($phone, $userAgent, $proxy)
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
     * @param string|null $proxy
     * @return array
     */
    protected function getRequestOptions(string $phone, ?string $userAgent, ?string $proxy): array
    {
        $options = [
            GuzzleHttp\RequestOptions::QUERY => [
                'bot_id' => $this->configurationRepository->get('telegram.bot.id'),
                'origin' => $this->configurationRepository->get('telegram.bot.domain'),
                'embed' => 1,
                'request_access' => 'write',
            ],
            GuzzleHttp\RequestOptions::FORM_PARAMS => [
                'phone' => $phone,
            ],
        ];

        if ($userAgent !== null) {
            $options[GuzzleHttp\RequestOptions::HEADERS]['User-Agent'] = $userAgent;
        }

        if ($proxy !== null) {
            $options[GuzzleHttp\RequestOptions::PROXY] = $proxy;
        }

        return $options;
    }
}

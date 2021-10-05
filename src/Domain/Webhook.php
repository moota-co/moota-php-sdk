<?php

namespace Moota\Moota\Domain;

use Moota\Moota\Config\Moota;
use Moota\Moota\DTO\Webhook\WebhookQueryParameterData;
use Moota\Moota\DTO\Webhook\WebhookStoreData;
use Moota\Moota\Exception\MootaException;
use Moota\Moota\Exception\Webhook\WebhookValidateException;
use Moota\Moota\Helper\Helper;
use Moota\Moota\Response\ParseResponse;
use Moota\Moota\Response\Webhook\WebhookIndexResponse;
use Zttp\Zttp;

class Webhook
{
    private string $secret_key;

    public function __construct(string $secret_key = '')
    {
        $this->secret_key = $secret_key;
    }

    /**
     * Your Webhook List
     *
     * @param WebhookQueryParameterData $webhookQueryParameterData
     * @return WebhookIndexResponse
     * @throws MootaException
     */
    public function getListWebhooks(WebhookQueryParameterData $webhookQueryParameterData)
    {
        $url = Moota::BASE_URL . Moota::ENDPOINT_WEBHOOK_INDEX;

        return (new ParseResponse(
            Zttp::withHeaders([
                'User-Agent'        => 'Moota/2.0',
                'Accept'            => 'application/json',
                'Authorization'     => 'Bearer ' . Moota::$ACCESS_TOKEN
            ])->get($url, $webhookQueryParameterData->toArray()), $url
        ))
        ->getResponse()
        ->getWebhookData();
    }

    /**
     * Create new webhook
     *
     * @param WebhookStoreData $webhookStoreData
     * @return ParseResponse
     * @throws MootaException
     */
    public function storeWebhook(WebhookStoreData $webhookStoreData)
    {
        $url = Moota::BASE_URL . Moota::ENDPOINT_WEBHOOK_STORE;

        return (new ParseResponse(
            Zttp::withHeaders([
                'User-Agent'        => 'Moota/2.0',
                'Accept'            => 'application/json',
                'Authorization'     => 'Bearer ' . Moota::$ACCESS_TOKEN
            ])->post($url, $webhookStoreData->toArray()), $url
        ))
            ->getResponse();
    }

    /**
     * Remove webhooks
     *
     * @param string $webhook_id
     * @return ParseResponse
     * @throws MootaException
     */
    public function removeWebhook(string $webhook_id)
    {
        $url = Helper::replace_uri_with_id(Moota::BASE_URL . Moota::ENDPOINT_WEBHOOK_DESTROY, $webhook_id, '{webhook_id}');

        return (new ParseResponse(
            Zttp::withHeaders([
                'User-Agent'        => 'Moota/2.0',
                'Accept'            => 'application/json',
                'Authorization'     => 'Bearer ' . Moota::$ACCESS_TOKEN
            ])->delete($url), $url
        ))
            ->getResponse();
    }

    /**
     * Get Webhook histories by webhook id
     *
     * @param string $webhook_id
     * @return WebhookIndexResponse
     * @throws MootaException
     */
    public function getWebhookHistory(string $webhook_id)
    {
        $url = Helper::replace_uri_with_id(Moota::BASE_URL . Moota::ENDPOINT_WEBHOOK_HISTORY, $webhook_id, '{webhook_id}');

        return (new ParseResponse(
            Zttp::withHeaders([
                'User-Agent'        => 'Moota/2.0',
                'Accept'            => 'application/json',
                'Authorization'     => 'Bearer ' . Moota::$ACCESS_TOKEN
            ])->get($url), $url
        ))
            ->getResponse()->getWebhookData();
    }

    /**
     * @param string|null $signature
     * @param string $payload
     * @throws WebhookValidateException
     */
    public function getResponse(?string $signature, string $payload) : array
    {
        if (!$this->isAuthenticated($signature, $payload)) {
            throw new WebhookValidateException();
        }

        return json_decode($payload, true);
    }

    /**
     * @param string $secret
     * @param string $payload
     *
     * @return bool
     */
    protected function isAuthenticated(?string $secret, ?string $payload): bool
    {
        return $secret === $this->hash($payload);
    }

    /**
     * Encrypt the payload using hash_hmac algorithm
     * And return it's sha256 value.
     *
     * @param string $payload
     *
     * @return string
     */
    private function hash(?string $payload): string
    {
        return hash_hmac('sha256', $payload, $this->secret_key);
    }
}
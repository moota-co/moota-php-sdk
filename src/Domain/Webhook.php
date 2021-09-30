<?php

namespace Moota\Moota\Domain;

use Moota\Moota\Exception\Webhook\WebhookValidateException;

class Webhook
{
    private string $secret_key;

    public function __construct(string $secret_key)
    {
        $this->secret_key = $secret_key;
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
<?php

namespace Moota\Moota\Response\Webhook;

class WebhookIndexResponse
{
    private array $webhooks;

    public function __construct(array $results)
    {
        $this->webhooks = $results['data'];
    }

    public function getWebhookData()
    {
        return $this->webhooks;
    }
}
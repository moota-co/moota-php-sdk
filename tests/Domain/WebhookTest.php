<?php

namespace Test\Domain;

use Moota\Moota\Domain\Webhook;
use Moota\Moota\Exception\Webhook\WebhookValidateException;
use PHPUnit\Framework\TestCase;

class WebhookTest extends TestCase
{
    public function testWebhook()
    {
        $webhook = new Webhook('AElSnSQj');

        $response_payload_json = file_get_contents(dirname(__FILE__, '2') . '/Mocking/webhook/MockWebhookResponse.json');
        $get_signature_from_header = '08b0c237eb830bcb321726fa2c6378122f6357a0b1b60cf4c4d362aa93380cca'; // signature from header

        $response = $webhook->getResponse($get_signature_from_header, $response_payload_json);
        $this->assertEquals(
            json_decode($response_payload_json, true),
            $response
        );
    }

    public function testFailSigantureWebhook()
    {
        $webhook = new Webhook('AElSnSQj');

        $response_payload_json = file_get_contents(dirname(__FILE__, '2') . '/Mocking/webhook/MockWebhookResponse.json');
        $get_signature_from_header = 'asdk234eqkalsjdn123ew12qasd23234234'; // signature from header

        $this->expectException(WebhookValidateException::class);
        $webhook->getResponse($get_signature_from_header, $response_payload_json);
    }
}
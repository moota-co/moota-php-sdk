<?php

namespace Test\Domain;

use Moota\Moota\Config\Moota;
use Moota\Moota\Domain\Webhook;
use Moota\Moota\DTO\Webhook\WebhookStoreData;
use Moota\Moota\Exception\MootaException;
use Moota\Moota\Exception\Webhook\WebhookValidateException;
use Moota\Moota\Helper\Helper;
use Moota\Moota\Response\ParseResponse;
use PHPUnit\Framework\TestCase;
use Test\Request;
use Test\server\GuzzleServer;

class WebhookTest extends TestCase
{
    public function testResponseWebhook()
    {
        $this->markTestSkipped('TODO ::');

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
        $this->markTestSkipped('TODO ::');

        $webhook = new Webhook('AElSnSQj');

        $response_payload_json = file_get_contents(dirname(__FILE__, '2') . '/Mocking/webhook/MockWebhookResponse.json');
        $get_signature_from_header = 'asdk234eqkalsjdn123ew12qasd23234234'; // signature from header

        $this->expectException(WebhookValidateException::class);
        $webhook->getResponse($get_signature_from_header, $response_payload_json);
    }

    public function testGetListWebhook()
    {
        $this->markTestSkipped('TODO ::');

        Moota::$ACCESS_TOKEN = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9';

        $response = Request::get(Moota::ENDPOINT_WEBHOOK_INDEX);
        $this->assertTrue($response->status() === 200);
        $this->assertEquals(
            $response->json()['data'],
            (new ParseResponse($response, Moota::ENDPOINT_WEBHOOK_INDEX))->getResponse()->getWebhookData()
        );
    }

    public function testCreateNewWebhook()
    {
        $this->markTestSkipped('TODO ::');

        Moota::$ACCESS_TOKEN = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9';

        $payload = (new WebhookStoreData(
            'https://app.moota.co/endpoint/webhook',
            'akjsdkj3',
            1,
            999,
            'credit',
            '', // set for all banks account
        ))->toArray();

        $response = Request::post(Moota::ENDPOINT_WEBHOOK_STORE, $payload);

        $this->assertTrue($response->status() == 200);
    }

    public function testFailCreateNewWebhook()
    {
        $this->markTestSkipped('TODO ::');

        Moota::$ACCESS_TOKEN = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9';

        $payload = (new WebhookStoreData(
            'https://app.moota.co/endpoint/webhook',
            'akjsdkj3',
            1,
            999,
            'assurance',
            '', // set for all banks account
        ))->toArray();

        $response = Request::post(Moota::ENDPOINT_WEBHOOK_STORE, $payload);
        $this->assertTrue($response->status() == 422);
        $this->expectException(MootaException::class);
        (new ParseResponse($response, Moota::ENDPOINT_WEBHOOK_STORE))->getResponse()->getWebhookData();
    }

    public function testGetHistoryWebhook()
    {
        $this->markTestSkipped('TODO ::');

        Moota::$ACCESS_TOKEN = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9';
        $webhook_id = 'hash_webhook_id';
        $url = Helper::replace_uri_with_id( Moota::ENDPOINT_WEBHOOK_HISTORY, $webhook_id, '{webhook_id}');

        $response = Request::get($url);

        $this->assertTrue($response->status() == 200);
        $this->assertEquals(
            $response->json()['data'],
            (new ParseResponse($response, Moota::ENDPOINT_WEBHOOK_STORE))->getResponse()->getWebhookData()
        );

    }
}
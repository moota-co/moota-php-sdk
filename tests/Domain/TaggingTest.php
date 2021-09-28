<?php


namespace Test\Domain;


use Moota\Moota\Config\Moota;
use Moota\Moota\Exception\MootaException;
use Moota\Moota\Helper\Helper;
use Moota\Moota\Response\ParseResponse;
use PHPUnit\Framework\TestCase;
use Test\Request;
use Test\server\ZttpServer;

class TaggingTest extends TestCase
{
    public static function setUpBeforeClass(): void
    {
        ZttpServer::start();
    }

    public function testGetListTag()
    {
        Moota::$ACCESS_TOKEN = "ajklshdasdjals";
        $params = ['assurance', 'cash'];
        $response = Request::get(Moota::ENDPOINT_TAGGING_INDEX, $params);

        $this->assertTrue($response->status() === 200);
        $this->assertEquals(
            $response->json()['tagging'],
            (new ParseResponse($response, Moota::ENDPOINT_TAGGING_INDEX))->getResponse()->getTaggingData()
        );
    }

    public function testStoreNewTag()
    {
        Moota::$ACCESS_TOKEN = "ajklshdasdjals";

        $payload = [
            'name' => 'assurance'
        ];

        $response = Request::post(Moota::ENDPOINT_TAGGING_STORE, $payload);
        $this->assertTrue($response->status() === 200);
        $this->assertEquals(
            $response->json()['tagging'],
            (new ParseResponse($response, Moota::ENDPOINT_TAGGING_STORE))->getResponse()->getTaggingData()
        );
    }

    public function testInvalidStoreNewTag()
    {
        Moota::$ACCESS_TOKEN = "ajklshdasdjals";

        $payload = [
            'name' => ''
        ];

        $response = Request::post(Moota::ENDPOINT_TAGGING_STORE, $payload);
        $this->assertTrue($response->status() === 422);
        $this->expectException(MootaException::class);
        (new ParseResponse($response, Moota::ENDPOINT_TAGGING_STORE));
    }

    public function testUpdateTag()
    {
        Moota::$ACCESS_TOKEN = "ajklshdasdjals";
        $tag_id = 'VLagzqBj42Ds';
        $payload = [
            'name' => 'assurance-car'
        ];

        $response = Request::put(Helper::replace_uri_with_id( Moota::ENDPOINT_TAGGING_UPDATE, $tag_id, '{tag_id}'), $payload);
        $this->assertTrue($response->status() === 200);
        $this->assertEquals(
            $response->json(),
            (new ParseResponse($response, Moota::ENDPOINT_TAGGING_UPDATE))->getResponse()
        );
    }

    public function testDestroyTag()
    {
        Moota::$ACCESS_TOKEN = "ajklshdasdjals";
        $tag_id = 'VLagzqBj42Ds';

        $response = Request::destroy(Helper::replace_uri_with_id( Moota::ENDPOINT_TAGGING_DESTROY, $tag_id, '{tag_id}'));
        $this->assertTrue($response->status() === 200);
        $this->assertEquals(
            $response->json(),
            (new ParseResponse($response, Moota::ENDPOINT_TAGGING_DESTROY))->getResponse()
        );
    }


}
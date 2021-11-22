<?php


namespace Test\Domain;


use Moota\Moota\Config\Moota;
use Moota\Moota\DTO\Tagging\TaggingQueryParameterData;
use Moota\Moota\DTO\Tagging\TaggingStoreData;
use Moota\Moota\DTO\Tagging\TaggingUpdateData;
use Moota\Moota\Exception\MootaException;
use Moota\Moota\Helper\Helper;
use Moota\Moota\Response\ParseResponse;
use PHPUnit\Framework\TestCase;
use Test\Request;
use Test\server\GuzzleServer;

class TaggingTest extends TestCase
{
    public function testGetListTag()
    {
        $this->markTestSkipped('TODO ::');

        Moota::$ACCESS_TOKEN = "ajklshdasdjals";
        $params = new TaggingQueryParameterData(['assurance', 'cash']);
        $response = Request::get(Moota::ENDPOINT_TAGGING_INDEX, $params->toArray());

        $this->assertTrue($response->status() === 200);
        $this->assertEquals(
            $response->json()['tagging'],
            (new ParseResponse($response, Moota::ENDPOINT_TAGGING_INDEX))->getResponse()->getTaggingData()
        );
    }

    public function testStoreNewTag()
    {
        $this->markTestSkipped('TODO ::');

        Moota::$ACCESS_TOKEN = "ajklshdasdjals";

        $payload = new TaggingStoreData( 'assurance' );

        $response = Request::post(Moota::ENDPOINT_TAGGING_STORE, $payload->toArray());
        $this->assertTrue($response->status() === 200);
        $this->assertEquals(
            $response->json()['tagging'],
            (new ParseResponse($response, Moota::ENDPOINT_TAGGING_STORE))->getResponse()->getTaggingData()
        );
    }

    public function testInvalidStoreNewTag()
    {
        $this->markTestSkipped('TODO ::');

        Moota::$ACCESS_TOKEN = "ajklshdasdjals";

        $payload = new TaggingStoreData('');

        $response = Request::post(Moota::ENDPOINT_TAGGING_STORE, $payload->toArray());
        $this->assertTrue($response->status() === 422);
        $this->expectException(MootaException::class);
        (new ParseResponse($response, Moota::ENDPOINT_TAGGING_STORE));
    }

    public function testUpdateTag()
    {
        $this->markTestSkipped('TODO ::');

        Moota::$ACCESS_TOKEN = "ajklshdasdjals";
        $payload = new TaggingUpdateData( 'VLagzqBj42Ds', 'assurance-car' );

        $response = Request::put(Helper::replace_uri_with_id( Moota::ENDPOINT_TAGGING_UPDATE, $payload->tag_id, '{tag_id}'), $payload->toArray());
        $this->assertTrue($response->status() === 200);
        $this->assertEquals(
            $response->json(),
            (new ParseResponse($response, Moota::ENDPOINT_TAGGING_UPDATE))->getResponse()
        );
    }

    public function testDestroyTag()
    {
        $this->markTestSkipped('TODO ::');

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
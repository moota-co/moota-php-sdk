<?php


namespace Test\Domain;

use Moota\Moota\Config\Moota;
use Moota\Moota\Domain\Mutation;
use Moota\Moota\DTO\Mutation\MutationAttachTaggingData;
use Moota\Moota\DTO\Mutation\MutationDestroyData;
use Moota\Moota\DTO\Mutation\MutationDetachTaggingData;
use Moota\Moota\DTO\Mutation\MutationNoteData;
use Moota\Moota\DTO\Mutation\MutationQueryParameterData;
use Moota\Moota\DTO\Mutation\MutationStoreData;
use Moota\Moota\DTO\Mutation\MutationUpdateTaggingData;
use Moota\Moota\Exception\MootaException;
use Moota\Moota\Exception\Mutation\MutationException;
use Moota\Moota\Helper\Helper;
use Moota\Moota\Response\ParseResponse;
use PHPUnit\Framework\TestCase;
use Test\server\ZttpServer;
use Zttp\Zttp;

class MutationTest extends TestCase
{
    public static function setUpBeforeClass(): void
    {

        ZttpServer::start();
    }

    function url($url)
    {
        return vsprintf('%s/%s', [
            'http://localhost:' . getenv('TEST_SERVER_PORT'),
            ltrim($url, '/'),
        ]);
    }

    public function testGetMutationResponse()
    {
        $params = new MutationQueryParameterData([
            'type'          => 'CR',
            'bank'          => 'klasdoi',
            'amount'        => '100012',
            'description'   => 'Test Mutations',
            'note'          => '',
            'date'          => '',
            'start_date'    => '2021-09-22',
            'end_date'      => '2020-09-23',
            'tag'           => 'tag_1,tag_2',
            'page'          => 1,
            'per_page'      => 20
        ]);

        $response = Zttp::withHeaders([
            'User-Agent'        => 'Moota/2.0',
            'Accept'            => 'application/json',
            'Authorization'     => 'Bearer ' . Moota::$ACCESS_TOKEN
        ])
        ->get($this->url(Moota::ENDPOINT_MUTATION_INDEX), $params->toArray());

        $this->assertTrue($response->status() === 200);
        $this->assertEquals(
            $response->json()['data'],
            (new ParseResponse($response, Moota::ENDPOINT_MUTATION_INDEX))->getResponse()->getData()
        );
    }

    public function testFailedGetMutationWithBankNotFound()
    {
        Moota::$ACCESS_TOKEN = 'abcdefghijklmnopqrstuvwxyz';
        $params = new MutationQueryParameterData([
            'type'          => 'CR',
            'bank'          => '1',
            'amount'        => '100012',
            'description'   => 'Test Mutations',
            'note'          => '',
            'date'          => '',
            'start_date'    => '2021-09-22',
            'end_date'      => '2020-09-23',
            'tag'           => 'tag_1,tag_2',
            'page'          => 1,
            'per_page'      => 20
        ]);

        $response = Zttp::withHeaders([
            'User-Agent'        => 'Moota/2.0',
            'Accept'            => 'application/json',
            'Authorization'     => 'Bearer ' . Moota::$ACCESS_TOKEN
        ])
            ->get($this->url(Moota::ENDPOINT_MUTATION_INDEX), $params->toArray());

        $this->expectException(MutationException::class);
        $this->assertTrue($response->status() === 404);
        (new ParseResponse($response, Moota::ENDPOINT_MUTATION_INDEX))->getResponse()->getData();
    }

    public function testStoreMutation()
    {
        Moota::$ACCESS_TOKEN = 'abcdefghijklmnopqrstuvwxyz';
        $payload = new MutationStoreData([
            'bank_id' => 'asdasd',
            'date'    => '2021-09-21',
            'note'    => 'Testing Note Mutation',
            'amount'  => '2000123',
            'type'    => 'CR'
        ]);

        $response = Zttp::withHeaders([
            'User-Agent'        => 'Moota/2.0',
            'Accept'            => 'application/json',
            'Authorization'     => 'Bearer ' . Moota::$ACCESS_TOKEN
        ])
            ->post($this->url(Moota::ENDPOINT_MUTATION_STORE), $payload->toArray());

        $this->assertTrue($response->status() === 200);
        $this->assertEquals([
            'error' => false,
            'mutation' => [
                'total' => 1,
                'new' => 1,
            ]
        ], (new ParseResponse($response, Moota::ENDPOINT_MUTATION_STORE))->getResponse()->getData());
    }

    public function testFailedStoreMutation()
    {
        Moota::$ACCESS_TOKEN = 'abcdefghijklmnopqrstuvwxyz';
        $payload = new MutationStoreData([
            'bank_id' => 'asdansd',
            'date'    => '2021-09-21',
            'note'    => 'Testing Note Mutation',
            'amount'  => '2000123',
            'type'    => ''
        ]);

        $response = Zttp::withHeaders([
            'User-Agent'        => 'Moota/2.0',
            'Accept'            => 'application/json',
            'Authorization'     => 'Bearer ' . Moota::$ACCESS_TOKEN
        ])
            ->post($this->url(Moota::ENDPOINT_MUTATION_STORE), $payload->toArray());

        $this->assertTrue($response->status() === 422);
        $this->expectException(MutationException::class);
        (new ParseResponse($response, Moota::ENDPOINT_MUTATION_STORE))->getResponse();
    }

    public function testAddNoteToMutation()
    {
        Moota::$ACCESS_TOKEN = 'abcdefghijklmnopqrstuvwxyz';
        $payload = new MutationNoteData([
            'mutation_id' => 'hash_mutation_id',
            'note'    => 'Testing Note Mutation',
        ]);

        $response = Zttp::withHeaders([
            'User-Agent'        => 'Moota/2.0',
            'Accept'            => 'application/json',
            'Authorization'     => 'Bearer ' . Moota::$ACCESS_TOKEN
        ])
            ->post($this->url(Helper::replace_uri_with_id(Moota::ENDPOINT_MUTATION_NOTE, $payload->mutation_id, '{mutation_id}')), $payload->toArray());

        $this->assertTrue($response->status() === 200);
        $this->assertEquals($response->json(), (new ParseResponse($response, Moota::ENDPOINT_MUTATION_NOTE))->getResponse());
    }

    public function testFailAddNoteMutation()
    {
        Moota::$ACCESS_TOKEN = 'abcdefghijklmnopqrstuvwxyz';
        $payload = new MutationNoteData([
            'mutation_id' => '1',
            'note'    => 'Testing Note Mutation',
        ]);
        $response = Zttp::withHeaders([
            'User-Agent'        => 'Moota/2.0',
            'Accept'            => 'application/json',
            'Authorization'     => 'Bearer ' . Moota::$ACCESS_TOKEN
        ])
            ->post($this->url(Helper::replace_uri_with_id(Moota::ENDPOINT_MUTATION_NOTE, $payload->mutation_id, '{mutation_id}')), $payload->toArray());

        $this->assertNotTrue($response->status(), 200);
        $this->expectException(MootaException::class);
        $this->assertEquals($response->json(), (new ParseResponse($response, Moota::ENDPOINT_MUTATION_NOTE))->getResponse());
    }

    public function testPushWebhookByWhenMutationId()
    {
        Moota::$ACCESS_TOKEN = 'abcdefghijklmnopqrstuvwxyz';
        $mutation_id = "hashing_mutation_id";

        $response = Zttp::withHeaders([
            'User-Agent'        => 'Moota/2.0',
            'Accept'            => 'application/json',
            'Authorization'     => 'Bearer ' . Moota::$ACCESS_TOKEN
        ])
            ->post($this->url(Helper::replace_uri_with_id(Moota::ENDPOINT_MUTATION_PUSH_WEBHOOK, $mutation_id, '{mutation_id}')), []);

        $this->assertTrue($response->status() === 200);
        $this->assertEquals($response->json(), (new ParseResponse($response, Helper::replace_uri_with_id(Moota::ENDPOINT_MUTATION_PUSH_WEBHOOK, $mutation_id, '{mutation_id}')))->getResponse());
    }

    public function testFailPushWebhookByWhenMutationIdNotFound()
    {
        Moota::$ACCESS_TOKEN = 'abcdefghijklmnopqrstuvwxyz';
        $mutation_id = "abcd";

        $response = Zttp::withHeaders([
            'User-Agent'        => 'Moota/2.0',
            'Accept'            => 'application/json',
            'Authorization'     => 'Bearer ' . Moota::$ACCESS_TOKEN
        ])
            ->post($this->url(Helper::replace_uri_with_id(Moota::ENDPOINT_MUTATION_PUSH_WEBHOOK, $mutation_id, '{mutation_id}')), []);

        $this->expectException(MootaException::class);
        $this->assertTrue($response->status() === 404);
        $this->assertEquals($response->json(), (new ParseResponse($response, Helper::replace_uri_with_id(Moota::ENDPOINT_MUTATION_PUSH_WEBHOOK, $mutation_id, '{mutation_id}')))->getResponse());
    }

    public function testdestroyMutation()
    {
        Moota::$ACCESS_TOKEN = 'abcdefghijklmnopqrstuvwxyz';
        $mutation_ids = new MutationDestroyData([
            'mutations' => ["hash_mutation_id", "hash_mutation_id"]
        ]);

        $response = Zttp::withHeaders([
            'User-Agent'        => 'Moota/2.0',
            'Accept'            => 'application/json',
            'Authorization'     => 'Bearer ' . Moota::$ACCESS_TOKEN
        ])
            ->post($this->url(Moota::ENDPOINT_MUTATION_DESTROY), $mutation_ids->toArray());

        $this->assertTrue($response->status() === 200);
        $this->assertEquals($response->json(), (new ParseResponse($response, Moota::ENDPOINT_MUTATION_DESTROY))->getResponse());
    }

    public function testFaildestroyMutation()
    {
        Moota::$ACCESS_TOKEN = 'abcdefghijklmnopqrstuvwxyz';
        $mutation_ids = new MutationDestroyData([
            'mutations' => ["abcdefg", "efgh"]
        ]);
        $response = Zttp::withHeaders([
            'User-Agent'        => 'Moota/2.0',
            'Accept'            => 'application/json',
            'Authorization'     => 'Bearer ' . Moota::$ACCESS_TOKEN
        ])
            ->post($this->url(Moota::ENDPOINT_MUTATION_DESTROY), $mutation_ids->toArray());

        $this->assertTrue($response->status() === 500);
        $this->expectException(MutationException::class);
        $this->assertEquals($response->json(), (new ParseResponse($response, Moota::ENDPOINT_MUTATION_DESTROY))->getResponse());
    }

    public function testFaildestroyMutationWithWrongRequestPayload()
    {
        Moota::$ACCESS_TOKEN = 'abcdefghijklmnopqrstuvwxyz';
        $mutation_ids = new MutationDestroyData([
            'mutations' => []
        ]);
        $response = Zttp::withHeaders([
            'User-Agent'        => 'Moota/2.0',
            'Accept'            => 'application/json',
            'Authorization'     => 'Bearer ' . Moota::$ACCESS_TOKEN
        ])
            ->post($this->url(Moota::ENDPOINT_MUTATION_DESTROY), $mutation_ids);

        $this->assertTrue($response->status() === 422);
        $this->expectException(MutationException::class);
        $this->assertEquals($response->json(), (new ParseResponse($response, Moota::ENDPOINT_MUTATION_DESTROY))->getResponse());
    }

    public function testAttachTagMutation()
    {
        Moota::$ACCESS_TOKEN = 'abcdefghijklmnopqrstuvwxyz';
        $payload = new MutationAttachTaggingData([
            "mutation_id" => '8aolk43WJxM',
            "name" => [
                "assurance", "..."
            ]
        ]);

        $url = Helper::replace_uri_with_id( Moota::ENDPOINT_ATTATCH_TAGGING_MUTATION, $payload->mutation_id, '{mutation_id}');
        $response = Zttp::withHeaders([
            'User-Agent'        => 'Moota/2.0',
            'Accept'            => 'application/json',
            'Authorization'     => 'Bearer ' . Moota::$ACCESS_TOKEN
        ])
        ->post($this->url($url), $payload->toArray());

        $this->assertTrue($response->status() === 200);
        $this->assertEquals($response->json(), (new ParseResponse($response, Moota::ENDPOINT_MUTATION_DESTROY))->getResponse());
    }

    public function testFailAttachTagMutation()
    {
        Moota::$ACCESS_TOKEN = 'abcdefghijklmnopqrstuvwxyz';
        $payload = new MutationAttachTaggingData([
            "mutation_id" => '8aolk43WJxM',
            "name" => [
                "assurance-car", "..."
            ]
        ]);

        $url = Helper::replace_uri_with_id( Moota::ENDPOINT_ATTATCH_TAGGING_MUTATION, $payload->mutation_id, '{mutation_id}');
        $response = Zttp::withHeaders([
            'User-Agent'        => 'Moota/2.0',
            'Accept'            => 'application/json',
            'Authorization'     => 'Bearer ' . Moota::$ACCESS_TOKEN
        ])
            ->post($this->url($url), $payload->toArray());

        $this->assertTrue($response->status() === 422);
        $this->expectException(MootaException::class);
        (new ParseResponse($response, Moota::ENDPOINT_ATTATCH_TAGGING_MUTATION));
    }

    public function testUpdateTagMutation()
    {
        Moota::$ACCESS_TOKEN = 'abcdefghijklmnopqrstuvwxyz';
        $payload = new MutationUpdateTaggingData([
            "mutation_id" => '8aolk43WJxM',
            "name" => [
                "assurance", "..."
            ]
        ]);

        $url = Helper::replace_uri_with_id( Moota::ENDPOINT_ATTATCH_TAGGING_MUTATION, $payload->mutation_id, '{mutation_id}');
        $response = Zttp::withHeaders([
            'User-Agent'        => 'Moota/2.0',
            'Accept'            => 'application/json',
            'Authorization'     => 'Bearer ' . Moota::$ACCESS_TOKEN
        ])
            ->post($this->url($url), $payload->toArray());

        $this->assertTrue($response->status() === 200);
        $this->assertEquals($response->json(), (new ParseResponse($response, Moota::ENDPOINT_UPDATE_TAGGING_MUTATION))->getResponse());
    }

    public function testDetachTagMutation()
    {
        Moota::$ACCESS_TOKEN = 'abcdefghijklmnopqrstuvwxyz';
        $payload = new MutationDetachTaggingData([
            "mutation_id" => '8aolk43WJxM',
            "name" => [
                "assurance", "..."
            ]
        ]);

        $url = Helper::replace_uri_with_id( Moota::ENDPOINT_ATTATCH_TAGGING_MUTATION, $payload->mutation_id, '{mutation_id}');
        $response = Zttp::withHeaders([
            'User-Agent'        => 'Moota/2.0',
            'Accept'            => 'application/json',
            'Authorization'     => 'Bearer ' . Moota::$ACCESS_TOKEN
        ])
            ->post($this->url($url), $payload->toArray());

        $this->assertTrue($response->status() === 200);
        $this->assertEquals($response->json(), (new ParseResponse($response, Moota::ENDPOINT_DETACH_TAGGING_MUTATION))->getResponse());
    }
}
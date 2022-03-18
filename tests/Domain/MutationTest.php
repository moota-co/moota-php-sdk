<?php


namespace Test\Domain;

use Moota\Moota\Config\Moota;
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
use Test\server\GuzzleServer;
use Zttp\Zttp;

class MutationTest extends TestCase
{
    public $access_token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiJucWllNHN3OGxsdyIsImp0aSI6IjM4MjA0MTFhOGQxZDQ3MjVjNTI5MzYxOGZiZDg4MjI2OWJiNTJiN2Q4OWRkOTZiZWE2M2EwNTljMWMzMGUzMzliYTRjMTM4ODQyMWE5Y2YyIiwiaWF0IjoxNjM3MzE0NTYxLjE2NTcyNywibmJmIjoxNjM3MzE0NTYxLjE2NTczLCJleHAiOjE2Njg4NTA1NjEuMTY0MTAzLCJzdWIiOiIxMTg3MyIsInNjb3BlcyI6WyJhcGkiXX0.tqyyOVL1T0AdxkuuJ5asUTaqPZgqMhE2htJUUIN4i-d8x4TVsBlBORiHXj-yx6TMK6v2HCV7q1sO2DajY1JSsS1o8XmkvLFehGDW7x6vrlEhZ5j78qz2P0nnoftRhBVo7kum7j0cbeybGq3oUjozWFRL2vMC6ZPGxFNNQ6l3sa4bGB9LY680kJPqQ0EBKg7gqA-Q0CLfC2PyBQUUCGJAOVb-At68l0vWNGaf149E6M66CYBUgknX12MwwtcwNIdiyxnRubgRS94PFkF8Id-MkX_DtzjB4W8gwveYoeKHsS6x5VezI0Rr1zGd2WvHfWRxDj-11cgMfG17dmpgSbIGCWoELhZlXL281T1pDaWIhOgRYfXP_LqieqKT55kWLX9EwKTyJER44Y34A_6w0SnAsncn8ZDukvf98a2qhYCUWP7-ZOC8b0EvtYqYjTEeSGFQmEG4JN2WU60VNj5qRsCOE1qqfjYunrgaw3XrWAr4sXutM9hFzEtcdEgbGuUGxTznlVq0Pkiognjk5nOWxvNlspdr2AjFwPIdzF70pWjgd0E06COyCRrQWzTuVFSIWmTj3g9el-Uz8H7z-9aMb309ZtUjTPSjrHp39VvCLt4wNzBWkiCyec2mrqXNsW9l_1yUx7MG8kOSCS0bjKVvUrPQ8YWjAFauUi-44mgLRUn7XxI";

    public function testGetMutationResponse()
    {
        $this->markTestSkipped('TODO ::');

        Moota::$ACCESS_TOKEN = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.....';
        $params = new MutationQueryParameterData(
            'CR',
            'klasdoi',
            '100012',
             'Test Mutations',
            '',
            '',
            '2021-09-22',
            '2020-09-23',
            'tag_1,tag_2',
             1,
             20
        );
        
        $response = GuzzleServer::request('GET', Moota::ENDPOINT_MUTATION_INDEX, [], $params->toArray());
       
        $this->assertTrue($response->getStatusCode() === 200);
        (new ParseResponse($response, Moota::ENDPOINT_MUTATION_INDEX))->getResponse()->getData();
    }

    public function testFailedGetMutationWithBankNotFound()
    {
        $this->markTestSkipped('TODO ::');

        Moota::$ACCESS_TOKEN = 'abcdefghijklmnopqrstuvwxyz';
        $params = new MutationQueryParameterData(
            'CR',
            '1',
            '100012',
            'Test Mutations',
            '',
            '',
            '2021-09-22',
            '2020-09-23',
            'tag_1,tag_2',
            1,
            20
        );

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
        $this->markTestSkipped('TODO ::');

        Moota::$ACCESS_TOKEN = 'abcdefghijklmnopqrstuvwxyz';
        $payload = new MutationStoreData(
            'asdasd',
            '2021-09-21',
            'Testing Note Mutation',
             '2000123',
             'CR'
        );

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
        $this->markTestSkipped('TODO ::');

        Moota::$ACCESS_TOKEN = 'abcdefghijklmnopqrstuvwxyz';
        $payload = new MutationStoreData(
            'asdansd',
            '2021-09-21',
            '2000123',
            '',
            'Testing Note Mutation',

        );

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
        $this->markTestSkipped('TODO ::');

        Moota::$ACCESS_TOKEN = 'abcdefghijklmnopqrstuvwxyz';
        $payload = new MutationNoteData( 'hash_mutation_id', 'Testing Note Mutation');

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
        $this->markTestSkipped('TODO ::');

        Moota::$ACCESS_TOKEN = 'abcdefghijklmnopqrstuvwxyz';
        $payload = new MutationNoteData( '1', 'Testing Note Mutation');
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
        $this->markTestSkipped('TODO ::');

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
        $this->markTestSkipped('TODO ::');

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
        $this->markTestSkipped('TODO ::');

        Moota::$ACCESS_TOKEN = 'abcdefghijklmnopqrstuvwxyz';
        $mutation_ids = new MutationDestroyData( ["hash_mutation_id", "hash_mutation_id"] );

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
        $this->markTestSkipped('TODO ::');

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
        $this->markTestSkipped('TODO ::');

        Moota::$ACCESS_TOKEN = 'abcdefghijklmnopqrstuvwxyz';
        $mutation_ids = new MutationDestroyData([]);
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
        $this->markTestSkipped('TODO ::');

        Moota::$ACCESS_TOKEN = 'abcdefghijklmnopqrstuvwxyz';
        $payload = new MutationAttachTaggingData(
            '8aolk43WJxM',
            [
                "assurance", "..."
            ]
        );

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
        $this->markTestSkipped('TODO ::');

        Moota::$ACCESS_TOKEN = 'abcdefghijklmnopqrstuvwxyz';
        $payload = new MutationAttachTaggingData(
            '8aolk43WJxM',
            [
                "assurance-car", "..."
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
        $this->markTestSkipped('TODO ::');

        Moota::$ACCESS_TOKEN = 'abcdefghijklmnopqrstuvwxyz';
        $payload = new MutationUpdateTaggingData(
            '8aolk43WJxM',
            [
                "assurance", "..."
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
        $this->markTestSkipped('TODO ::');

        Moota::$ACCESS_TOKEN = 'abcdefghijklmnopqrstuvwxyz';
        $payload = new MutationDetachTaggingData(
            '8aolk43WJxM',
             [
                "assurance", "..."
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
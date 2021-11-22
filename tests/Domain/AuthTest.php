<?php

namespace Test\Domain;

use Moota\Moota\Config\Moota;
use Moota\Moota\DTO\Auth\LoginData;
use Moota\Moota\DTO\Auth\ScopesData;
use PHPUnit\Framework\TestCase;
use Test\server\GuzzleServer;

class AuthTest extends TestCase
{

    public function testAuthLogin()
    {
        $payload = new LoginData(
            'mugypleci@gmail.com',
            'plecimugy123',
            new ScopesData(
                true
            )
        );

        $results = GuzzleServer::request('POST', Moota::ENDPOINT_AUTH_LOGIN, [], $payload->toArray());
        $response_parse = (new \Moota\Moota\Response\ParseResponse($results, Moota::ENDPOINT_AUTH_LOGIN))->getResponse();
        $this->assertTrue($results->getStatusCode() === 200);
        $this->assertArrayHasKey(
            "access_token",
            $response_parse
        );
    }

    public function testAuthLogout()
    {
        Moota::$ACCESS_TOKEN = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9';
        $response = GuzzleServer::request('POST', Moota::ENDPOINT_AUTH_LOGOUT, ['Authorization' => 'Bearer '. Moota::$ACCESS_TOKEN]);
        $this->assertTrue($response->getStatusCode() === 200);
        $this->assertEquals(
            ["message" => "OK"],
            (new \Moota\Moota\Response\ParseResponse($response, Moota::ENDPOINT_AUTH_LOGIN))->getResponse()
        );
    }
}
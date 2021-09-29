<?php

namespace Test\Domain;

use Moota\Moota\Config\Moota;
use Moota\Moota\Domain\Auth;
use Moota\Moota\DTO\Auth\LoginData;
use Moota\Moota\DTO\Auth\ScopesData;
use PHPUnit\Framework\TestCase;
use Test\Request;
use Test\server\ZttpServer;

class AuthTest extends TestCase
{
    public static function setUpBeforeClass(): void
    {
        ZttpServer::start();
    }

    public function testAuthLogin()
    {
        $paylaod = [
            'email' => 'user@moota.co',
            'password' => 'password_hash',
            'scopes' => ['api']
        ];

        $response = Request::post(Moota::ENDPOINT_AUTH_LOGIN, $paylaod);
        $this->assertTrue($response->status() === 200);
        $this->assertEquals(
            $response->json(),
            (new \Moota\Moota\Response\ParseResponse($response, Moota::ENDPOINT_AUTH_LOGIN))->getResponse()
        );
    }

    public function testAuthLogout()
    {
        Moota::$ACCESS_TOKEN = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9';
        $access_token = Moota::$ACCESS_TOKEN;

        $response = Request::post(Moota::ENDPOINT_AUTH_LOGOUT);
        $this->assertTrue($response->status() === 200);
        $this->assertEquals(
            $response->json(),
            (new \Moota\Moota\Response\ParseResponse($response, Moota::ENDPOINT_AUTH_LOGIN))->getResponse()
        );
    }
}
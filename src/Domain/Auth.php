<?php

namespace Moota\Moota\Domain;

use GuzzleHttp\Client;
use Moota\Moota\Config\Moota;
use Moota\Moota\DTO\Auth\LoginData;
use Moota\Moota\Exception\MootaException;
use Moota\Moota\Response\ParseResponse;
use Zttp\Zttp;

class Auth
{
    protected $client;

    protected array $headers = [];

    public function __construct()
    {
        $this->client = new Client(['base_uri' => Moota::BASE_URL]);
        $this->headers = [
            'User-Agent' => 'Moota/2.0',
            'Accept'     => 'application/json',
            'Authorization' => 'Bearer ' . Moota::$ACCESS_TOKEN
        ];
    }

    /**
     * Get Access Token
     *
     * @throws MootaException
     */
    public function login(LoginData $authData)
    {
        try {
            $payload = array_merge($authData->toArray(), ['scopes' => array_keys(array_filter($authData->scopes->toArray()))]);

            $response = $this->client->post(  Moota::ENDPOINT_AUTH_LOGIN, [
                'headers' => $this->headers,
                'json' => $payload
            ]);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $response = $e->getResponse();
        } finally {
            return (new \Moota\Moota\Response\ParseResponse($response, Moota::ENDPOINT_AUTH_LOGIN))->getResponse();
        }
    }

    /**
     * Destroy Access Token
     *
     * @throws MootaException
     */
    public function logout()
    {
        try {
            $response = $this->client->post(  Moota::ENDPOINT_AUTH_LOGOUT, [
                'headers' => $this->headers,
                'json' => []
            ]);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $response = $e->getResponse();
        } finally {
            return (new \Moota\Moota\Response\ParseResponse($response, Moota::ENDPOINT_AUTH_LOGIN))->getResponse();
        }
    }
}
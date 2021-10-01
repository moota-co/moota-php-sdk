<?php

namespace Moota\Moota\Domain;

use Moota\Moota\Config\Moota;
use Moota\Moota\DTO\Auth\LoginData;
use Moota\Moota\Exception\MootaException;
use Moota\Moota\Response\ParseResponse;
use Zttp\Zttp;

class Auth
{
    /**
     * Get Access Token
     *
     * @throws MootaException
     */
    public function login(LoginData $authData)
    {
        $url = Moota::BASE_URL . Moota::ENDPOINT_AUTH_LOGIN;
        $payload = array_merge($authData->toArray(), ['scopes' => array_keys(array_filter($authData->scopes->toArray()))]);
        return (new ParseResponse(
            Zttp::withHeaders([
                'User-Agent'        => 'Moota/2.0',
                'Accept'            => 'application/json',
            ])->post($url, $payload), $url
        ))->getResponse();
    }

    /**
     * Destroy Access Token
     *
     * @throws MootaException
     */
    public function logout()
    {
        $url = Moota::BASE_URL . Moota::ENDPOINT_AUTH_LOGOUT;

        return (new ParseResponse(
            Zttp::withHeaders([
                'User-Agent'        => 'Moota/2.0',
                'Accept'            => 'application/json',
            ])->post($url), $url
        ))->getResponse();
    }
}
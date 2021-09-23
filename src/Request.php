<?php

namespace Moota\Moota;

//use GuzzleHttp\Client;

use Zttp\Zttp;

class Request
{

    /**
     * Request Method
     *
     * @param $method
     * @param $endpoint
     * @param array $config
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function get($endpoint, $params = [])
    {
        return Zttp::withHeaders([
            'User-Agent'        => 'Moota/2.0',
            'Accept'            => 'application/json',
            'decode_content' => false,
            'Authorization'     => 'Bearer ' . Config::$access_token
        ])->get(Config::BASE_URL . $endpoint);
    }
}
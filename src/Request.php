<?php

namespace Moota\Moota;

use GuzzleHttp\Client;

class Request
{
    public static $base_url = 'https://app.moota.co/api/v2/';

    public static $access_token;

    public static function request($method, $endpoint, $config = [])
    {
        $client = new Client();
        $client->request($method, self::$base_url . $endpoint, array_merge([
            'headers' => [
                'User-Agent' => 'Moota/2.0',
                'Accept'     => 'application/json',
                'Authorization'      => 'Bearer ' . self::$access_token
            ]
        ], $config));
    }
}
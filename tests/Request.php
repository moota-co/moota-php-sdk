<?php


namespace Test;

use Moota\Moota\Config\Moota;
use Zttp\Zttp;

class Request
{
    public static function url($url)
    {
        return vsprintf('%s/%s', [
            'http://localhost:' . getenv('TEST_SERVER_PORT'),
            ltrim($url, '/'),
        ]);
    }

    public static function get(string $endpoint, array $params = [])
    {
        return Zttp::withHeaders([
            'User-Agent'        => 'Moota/2.0',
            'Accept'            => 'application/json',
            'Authorization'     => 'Bearer ' . Moota::$ACCESS_TOKEN
        ])
            ->get(self::url($endpoint), $params);
    }

    public static function post(string $endpoint, array $payload = [])
    {
        return Zttp::withHeaders([
            'User-Agent'        => 'Moota/2.0',
            'Accept'            => 'application/json',
            'Authorization'     => 'Bearer ' . Moota::$ACCESS_TOKEN
        ])
            ->post(self::url($endpoint), $payload);
    }

    public static function put(string $endpoint, array $payload = [])
    {
        return Zttp::withHeaders([
            'User-Agent'        => 'Moota/2.0',
            'Accept'            => 'application/json',
            'Authorization'     => 'Bearer ' . Moota::$ACCESS_TOKEN
        ])
            ->put(self::url($endpoint), $payload);
    }

    public static function destroy(string $endpoint)
    {
        return Zttp::withHeaders([
            'User-Agent'        => 'Moota/2.0',
            'Accept'            => 'application/json',
            'Authorization'     => 'Bearer ' . Moota::$ACCESS_TOKEN
        ])
            ->put(self::url($endpoint));
    }

    public static function postFile(string $endpoint, array $payload)
    {
        return Zttp::asMultipart()->post(self::url('/multi-part'), [
            [
                'name' => 'test-file',
                'contents' => 'test contents',
                'filename' => $payload['file'],
            ],
        ]);
//        return Zttp::withHeaders([
//                'User-Agent'        => 'Moota/2.0',
//                'Accept'            => 'application/json',
//                'Authorization'     => 'Bearer ' . Moota::$ACCESS_TOKEN
//            ])
//            ->post(self::url($endpoint), $payload);
    }
}
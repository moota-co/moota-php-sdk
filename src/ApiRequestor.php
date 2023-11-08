<?php

namespace Moota\Moota;

class ApiRequestor
{
    private static array $data;

    public static function get($url, $data = [])
    {
        // TODO Implementation
    }

    public function post($url, $data)
    {
        // TODO Implementation
    }

    public static function remoteCall($url, $acces_token, $method)
    {
        $ch = curl_init();
        if (empty($acces_token) || $acces_token == "")
        {
            throw new \Exception(
                "access token can not nullable " .
                "Get Access Token From Moota Integrations Menu " .
                "See https://app.moota.co/integrations/personal " .
                "for the details or contact our support at hi@moota.co"
            );
        } else if (preg_match('/\s/', $acces_token)) {
            throw new \Exception(
                "access token contains space "
            );
        }

        $curl_options = [
            CURLOPT_URL => $url,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Accept: application/json',
                'User-Agent: midtrans-php-v2.5.2',
                'Authorization: Bearer ' . $acces_token
            ),
            CURLOPT_RETURNTRANSFER => 1
        ];
    }
}
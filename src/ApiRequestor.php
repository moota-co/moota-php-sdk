<?php

namespace Moota\Moota;

class ApiRequestor
{
    private static array $data;

    public static function get(string $url, string $access_token, ?array $data = [])
    {
        if(count($data) > 0){
            $url = $url . \http_build_query($data);
        }

        return self::remoteCall($url, $access_token, "get");
    }

    public static function post(string $url, string $access_token, ?array $data = [])
    {
        return self::remoteCall($url, $access_token, "post", $data);
    }

    public static function remoteCall(string $url, string $access_token, string $method, ?array $data = []) : ?object
    {
        $ch = curl_init();
        if (empty($access_token) || $access_token == "")
        {
            throw new \Exception(
                "access token can not nullable " .
                "Get Access Token From Moota Integrations Menu " .
                "See https://app.moota.co/integrations/personal " .
                "for the details or contact our support at hi@moota.co"
            );

        } else if (preg_match('/\s/', $access_token)) {
            throw new \Exception(
                "access token contains space "
            );
        }

        $curl_options = [
            CURLOPT_URL => $url,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Accept: application/json',
                'User-Agent: moota-php-v3.0.0',
                'Authorization: Bearer ' . $access_token
            ),
            CURLOPT_RETURNTRANSFER => 1
        ];

        if($method == 'post'){

            $curl_options[CURLOPT_POST] = 1;
            $curl_options[CURLOPT_RETURNTRANSFER] = 1;
            $curl_options[CURLOPT_POSTFIELDS] = \json_encode($data);
        }

        \curl_setopt_array($ch, $curl_options);

        $response = \curl_exec($ch);
        $error    = \curl_error($ch);
        $errno    = \curl_errno($ch);
        
        if (\is_resource($ch)) {
            \curl_close($ch);
        }

        if (0 !== $errno) {
            throw new \RuntimeException($error, $errno);
        }
        
        return json_decode($response);
    }
}
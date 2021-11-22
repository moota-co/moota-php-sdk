<?php


namespace Test;


use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;

class Request implements \Psr\Http\Message\RequestInterface
{

//    public static function url($url)
//    {
//        return vsprintf('%s/%s', [
//            'http://localhost:' . getenv('TEST_SERVER_PORT'),
//            ltrim($url, '/'),
//        ]);
//    }
//
//    public static function get(string $endpoint, array $params = [])
//    {
//        return Zttp::withHeaders([
//            'User-Agent'        => 'Moota/2.0',
//            'Accept'            => 'application/json',
//            'Authorization'     => 'Bearer ' . Moota::$ACCESS_TOKEN
//        ])
//            ->get(self::url($endpoint), $params);
//    }
//
//    public static function post(string $endpoint, array $payload = [])
//    {
//        return Guzzle::withHeaders([
//            'User-Agent'        => 'Moota/2.0',
//            'Accept'            => 'application/json',
//            'Authorization'     => 'Bearer ' . Moota::$ACCESS_TOKEN
//        ])
//            ->post(self::url($endpoint), $payload);

//    }
//
//    public static function put(string $endpoint, array $payload = [])
//    {
//        return Zttp::withHeaders([
//            'User-Agent'        => 'Moota/2.0',
//            'Accept'            => 'application/json',
//            'Authorization'     => 'Bearer ' . Moota::$ACCESS_TOKEN
//        ])
//            ->put(self::url($endpoint), $payload);
//    }
//
//    public static function destroy(string $endpoint)
//    {
//        return Zttp::withHeaders([
//            'User-Agent'        => 'Moota/2.0',
//            'Accept'            => 'application/json',
//            'Authorization'     => 'Bearer ' . Moota::$ACCESS_TOKEN
//        ])
//            ->put(self::url($endpoint));
//    }
//
//    public static function postFile(string $endpoint, array $payload)
//    {
//        return Zttp::asMultipart()->post(self::url('/multi-part'), [
//            [
//                'name' => 'test-file',
//                'contents' => 'test contents',
//                'filename' => $payload['file'],
//            ],
//        ]);
////        return Zttp::withHeaders([
////                'User-Agent'        => 'Moota/2.0',
////                'Accept'            => 'application/json',
////                'Authorization'     => 'Bearer ' . Moota::$ACCESS_TOKEN
////            ])
////            ->post(self::url($endpoint), $payload);
//    }
    public function getProtocolVersion()
    {
        // TODO: Implement getProtocolVersion() method.
    }

    public function withProtocolVersion($version)
    {
        // TODO: Implement withProtocolVersion() method.
    }

    public function getHeaders()
    {
        // TODO: Implement getHeaders() method.
    }

    public function hasHeader($name)
    {
        // TODO: Implement hasHeader() method.
    }

    public function getHeader($name)
    {
        // TODO: Implement getHeader() method.
    }

    public function getHeaderLine($name)
    {
        // TODO: Implement getHeaderLine() method.
    }

    public function withHeader($name, $value)
    {
        // TODO: Implement withHeader() method.
    }

    public function withAddedHeader($name, $value)
    {
        // TODO: Implement withAddedHeader() method.
    }

    public function withoutHeader($name)
    {
        // TODO: Implement withoutHeader() method.
    }

    public function getBody()
    {
        // TODO: Implement getBody() method.
    }

    public function withBody(StreamInterface $body)
    {
        // TODO: Implement withBody() method.
    }

    public function getRequestTarget()
    {
        // TODO: Implement getRequestTarget() method.
    }

    public function withRequestTarget($requestTarget)
    {
        // TODO: Implement withRequestTarget() method.
    }

    public function getMethod()
    {
        // TODO: Implement getMethod() method.
    }

    public function withMethod($method)
    {
        // TODO: Implement withMethod() method.
    }

    public function getUri()
    {
        // TODO: Implement getUri() method.
    }

    public function withUri(UriInterface $uri, $preserveHost = false)
    {
        // TODO: Implement withUri() method.
    }
}
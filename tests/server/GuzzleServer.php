<?php


namespace Test\server;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Moota\Moota\Config\Moota;
use Moota\Moota\Helper\Helper;
use Test\Request;

class GuzzleServer
{
    /**
     * @throws GuzzleException
     */
    private static function mocking(string $method, string $endpoint, array $headers = [], array $response = [], int $status_code = 200): \GuzzleHttp\Psr7\Response
    {
        $mock = new MockHandler([
            new Response($status_code, $headers, json_encode($response, true)),
            new Response($status_code, ['Content-Length' => 0]),
            new RequestException('Error Communicating with Server', new Request())
        ]);

        $client = new Client([
            'handler' => HandlerStack::create($mock)
        ]);

        return $client->request($method, $endpoint);
    }

    public static function request(string $method, string $endpoint, array $headers = [], array $payload = []): \GuzzleHttp\Psr7\Response
    {

        return match ($endpoint) {
            Moota::ENDPOINT_AUTH_LOGIN => self::authLogin($method,  $endpoint,  $headers,  $payload),
            Moota::ENDPOINT_AUTH_LOGOUT => self::authLogout($method,  $endpoint,  $headers,  $payload),
            Moota::ENDPOINT_BANK_STORE => self::storeBankAccount($method,  $endpoint,  $headers,  $payload),
            Moota::ENDPOINT_BANK_INDEX => self::getListBankAccount($method,  $endpoint,  $headers,  $payload),
            Helper::replace_uri_with_id(Moota::ENDPOINT_BANK_UPDATE, 'hashing_qwopejs_id', '{bank_id}') => self::updateBankAccount($method,  $endpoint,  $headers,  $payload),
            Helper::replace_uri_with_id(Moota::ENDPOINT_BANK_UPDATE, '1', '{bank_id}') => self::updateBankAccount($method,  $endpoint,  $headers,  $payload),
            Helper::replace_uri_with_id(Moota::ENDPOINT_BANK_REFRESH_MUTATION, 'hash_oqwjas_id', '{bank_id}') => self::refreshMutation($method,  $endpoint,  $headers,  $payload),
            Helper::replace_uri_with_id(Moota::ENDPOINT_BANK_REFRESH_MUTATION, 'hash_aswj_id', '{bank_id}') => self::refreshMutation($method,  $endpoint,  $headers,  $payload),
            Helper::replace_uri_with_id(Moota::ENDPOINT_BANK_DESTROY, 'hash_kiusd_id', '{bank_id}') => self::deleteBankAccount($method,  $endpoint,  $headers,  $payload),
            Helper::replace_uri_with_id(Moota::ENDPOINT_BANK_DESTROY, 'hash_qweas_id', '{bank_id}') => self::deleteBankAccount($method,  $endpoint,  $headers,  $payload),
            Helper::replace_uri_with_id(Moota::ENDPOINT_BANK_EWALLET_REQUEST_OTP, 'hash_ewallet_id', '{bank_id}') => self::requestOTPEwallet($method,  $endpoint,  $headers,  $payload),
            Helper::replace_uri_with_id(Moota::ENDPOINT_BANK_EWALLET_VERIFICATION_OTP, 'hash_verification_ewallet_id', '{bank_id}') => self::verificationOTPEwallet($method,  $endpoint,  $headers,  $payload),
            Moota::ENDPOINT_AUTH_LOGIN => self::authLogin($method,  $endpoint,  $headers,  $payload),

            default => throw new \Exception('Unexpected match value'),
        };
    }

    private static function authLogin(string $method, string $endpoint, array $headers, array $payload): \GuzzleHttp\Psr7\Response
    {
        $mock_success_response = file_get_contents(dirname(__FILE__, '3') . '/tests/Mocking/Auth/MockAuthResponse.json');
        $response = json_decode($mock_success_response, true);
        return self::mocking( $method,  $endpoint,  $headers,  $response, 200);
    }

    private static function authLogout(string $method, string $endpoint, array $headers, array $payload): \GuzzleHttp\Psr7\Response
    {
        $mock_success_response = file_get_contents(dirname(__FILE__, '3') . '/tests/Mocking/MockRequestSuccessResponse.json');
        $response = json_decode($mock_success_response, true);
        return self::mocking( $method,  $endpoint,  $headers,  $response, 200);
    }

    private static function getListBankAccount(string $method, string $endpoint, array $headers, array $payload) : \GuzzleHttp\Psr7\Response
    {
        $mock_success_response = file_get_contents(dirname(__FILE__, '3') . '/tests/Mocking/BankAccount/MockingListBankAccountResponse.json');
        $response = json_decode($mock_success_response, true);
        return self::mocking( $method,  $endpoint,  $headers,  $response, 200);
    }

    private static function storeBankAccount(string $method, string $endpoint, array $headers, array $payload) : \GuzzleHttp\Psr7\Response
    {
        $mock_success_response = file_get_contents(dirname(__FILE__, '3') . '/tests/Mocking/BankAccount/MockStoreBankAccountResponse.json');
        $mock_fail_bank_account_response = file_get_contents(dirname(__FILE__, '3') . '/tests/Mocking/BankAccount/MockInvalidStoreBankAccountResponse.json');
        $response = json_decode($mock_success_response, true);
        $status = 200;

        if(! in_array($payload['bank_type'], Moota::BANK_TYPES)) {
            $status = 422;
            $response = json_decode($mock_fail_bank_account_response, true);
        }
        return self::mocking( $method,  $endpoint,  $headers,  $response, $status);
    }

    private static function updateBankAccount(string $method, string $endpoint, array $headers, array $payload) : \GuzzleHttp\Psr7\Response
    {
        $mock_success_response = file_get_contents(dirname(__FILE__, '3') . '/tests/Mocking/BankAccount/MockUpdateBankAccountResponse.json');
        $mock_fail_bank_account_response = file_get_contents(dirname(__FILE__, '3') . '/tests/Mocking/BankAccount/MockFailUpdateBankAccountResponse.json');
        $response = json_decode($mock_success_response, true);
        $status = 200;
        if($endpoint == '/api/v2/bank/update/1') {
            $status = 500;
            $response = json_decode($mock_fail_bank_account_response, true);
        }

        return self::mocking( $method,  $endpoint,  $headers,  $response, $status);
    }

    private static function refreshMutation(string $method, string $endpoint, array $headers, array $payload) : \GuzzleHttp\Psr7\Response
    {
        $mock_success_response = file_get_contents(dirname(__FILE__, '3') . '/tests/Mocking/MockRequestSuccessResponse.json');
        $mock_fail_response = file_get_contents(dirname(__FILE__, '3') . '/tests/Mocking/MockFailRequestWithPointNotEnough.json');
        $response = json_decode($mock_success_response, true);
        $status = 200;

        if($endpoint === '/api/v2/bank/hash_aswj_id/refresh'){
            $status = 422;
            $response = json_decode($mock_fail_response, true);
        }
        return self::mocking( $method,  $endpoint,  $headers,  $response, $status);
    }

    private static function deleteBankAccount(string $method, string $endpoint, array $headers, array $payload): \GuzzleHttp\Psr7\Response
    {
        $mock_success_response = file_get_contents(dirname(__FILE__, '3') . '/tests/Mocking/MockRequestSuccessResponse.json');
        $mock_fail_response = file_get_contents(dirname(__FILE__, '3') . '/tests/Mocking/MockRequestNotFound.json');

        $response = json_decode($mock_success_response, true);
        $status = 200;
        if($endpoint == "/api/v2/bank/hash_qweas_id/destroy") {
            $status = 500;
            $response = json_decode($mock_fail_response, true);
        }
        return self::mocking( $method,  $endpoint,  $headers,  $response, $status);
    }

    private static function requestOTPEwallet(string $method, string $endpoint, array $headers, array $payload): \GuzzleHttp\Psr7\Response
    {
        $mock_success_response = file_get_contents(dirname(__FILE__, '3') . '/tests/Mocking/BankAccount/MockSuccessRequestOtpResponse.json');
        $response = json_decode($mock_success_response, true);
        $status = 200;

        return self::mocking( $method,  $endpoint,  $headers,  $response, $status);
    }

    private static function verificationOTPEwallet(string $method, string $endpoint, array $headers, array $payload)
    {
        $mock_success_response = file_get_contents(dirname(__FILE__, '3') . '/tests/Mocking/MockRequestSuccessResponse.json');
        $response = json_decode($mock_success_response, true);
        $status = 200;

        return self::mocking( $method,  $endpoint,  $headers,  $response, $status);
    }
}
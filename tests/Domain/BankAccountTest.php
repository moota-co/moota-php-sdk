<?php


namespace Test\Domain;


use Moota\Moota\Config;
use Moota\Moota\Exception\MootaException;
use Moota\Moota\Helper\Helper;
use Moota\Moota\ParseResponse;
use PHPUnit\Framework\TestCase;
use Test\Request;
use Test\server\ZttpServer;

class BankAccountTest extends TestCase
{
    public static function setUpBeforeClass(): void
    {

        ZttpServer::start();
    }

    public function testGetListBankAccount()
    {
        Config::$ACCESS_TOKEN = "ajklshdasdjals";

        $response = Request::get(Config::ENDPOINT_BANK_INDEX);

        $this->assertTrue($response->status() === 200);
        $this->assertEquals(
            $response->json(),
            (new ParseResponse($response, Config::ENDPOINT_BANK_INDEX))->getResponse()->getBankData()
        );
    }

    public function testStoreBankAccount()
    {
        Config::$ACCESS_TOKEN = "ajklshdasdjals";

        $payload = [
            "corporate_id"=> "",
            "bank_type"=> Config::BANK_TYPES[0],
            "username"=> "loream",  //for gojek and ovo fill with mobile phone number
            "password"=> "your password",
            "name_holder"=> "loream kasma",
            "account_number"=> 16899030,
            "is_active"=> true
        ];

        $response = Request::post(Config::ENDPOINT_BANK_STORE, $payload);
        $this->assertTrue($response->status() === 200);
        $this->assertEquals(
            $response->json(),
            (new ParseResponse($response, Config::ENDPOINT_BANK_INDEX))->getResponse()->getBankData()
        );
    }

    public function testFailStoreBankAccountWithInvalidRequestPayload()
    {
        Config::$ACCESS_TOKEN = "ajklshdasdjals";

        $payload = [
            "corporate_id"=> "",
            "bank_type"=> "B C A",
            "username"=> "loream",  //for gojek and ovo fill with mobile phone number
            "password"=> "your password",
            "name_holder"=> "loream kasma",
            "account_number"=> 16899030,
            "is_active"=> true
        ];

        $response = Request::post(Config::ENDPOINT_BANK_STORE, $payload);
        $this->assertTrue($response->status() === 422);
        $this->expectException(MootaException::class);
        (new ParseResponse($response, Config::ENDPOINT_BANK_INDEX))->getResponse();
        $this->expectExceptionMessage('The given data was invalid.');
    }

    public function testUpdateBankAccount()
    {
        Config::$ACCESS_TOKEN = "ajklshdasdjals";

        $bank_id = "hashing_qwopejs_id";

        $payload = [
            "username"=> "jhon",  //for gojek and ovo fill with mobile phone number
        ];

        $url = Helper::replace_uri_with_id(Config::ENDPOINT_BANK_UPDATE, $bank_id, '{bank_id}');
        $response = Request::put($url, $payload);

        $this->assertTrue($response->status() === 200);
        $this->assertContains($payload['username'], $response->json()['bank']);
    }

    public function testFailUpdateBankAccountWithWrongId()
    {
        Config::$ACCESS_TOKEN = "ajklshdasdjals";

        $bank_id = 1;

        $payload = [
            "username"=> "jhon",  //for gojek and ovo fill with mobile phone number
        ];

        $url = Helper::replace_uri_with_id(Config::ENDPOINT_BANK_UPDATE, $bank_id, '{bank_id}');
        $response = Request::put($url, $payload);

        $this->assertTrue($response->status() === 500);
        $this->expectException(MootaException::class);
        (new ParseResponse($response, $url))->getResponse();
        $this->expectExceptionMessage("Data tidak ditemukan");
    }

    public function testCanRefreshMutation()
    {
        Config::$ACCESS_TOKEN = "ajklshdasdjals";

        $bank_id = 'hash_oqwjas_id';
        $url = Helper::replace_uri_with_id(Config::ENDPOINT_BANK_REFRESH_MUTATION, $bank_id, '{bank_id}');
        $response = Request::post($url);

        $this->assertTrue($response->status() === 200);
        $this->assertEquals(['message' => 'OK'], $response->json());
    }

    public function testCanFailRefreshMutationWithBalanceNotEnough()
    {
        Config::$ACCESS_TOKEN = "ajklshdasdjals";

        $bank_id = 'hash_aswj_id';
        $url = Helper::replace_uri_with_id(Config::ENDPOINT_BANK_REFRESH_MUTATION, $bank_id, '{bank_id}');
        $response = Request::post($url);

        $this->assertTrue($response->status() === 422);
        $this->expectException(MootaException::class);
        $this->assertEquals((new ParseResponse($response, $url))->getResponse(), $response->json());
    }

    public function testDestroyBankAccount()
    {
        Config::$ACCESS_TOKEN = "ajklshdasdjals";

        $bank_id = 'hash_kiusd_id';
        $url = Helper::replace_uri_with_id(Config::ENDPOINT_BANK_DESTROY, $bank_id, '{bank_id}');
        $response = Request::post($url);

        $this->assertTrue($response->status() === 200);
        $this->assertEquals(['message' => 'OK'], $response->json());
    }

    public function testFailDestroyBankAccount()
    {
        Config::$ACCESS_TOKEN = "ajklshdasdjals";

        $bank_id = 'hash_qweas_id';
        $url = Helper::replace_uri_with_id(Config::ENDPOINT_BANK_DESTROY, $bank_id, '{bank_id}');
        $response = Request::post($url);

        $this->assertTrue($response->status() === 500);
        $this->expectException(MootaException::class);
        $this->assertEquals((new ParseResponse($response, $url))->getResponse(), $response->json());
    }

    public function testRequestOtpEwallet()
    {
        Config::$ACCESS_TOKEN = "ajklshdasdjals";

        $bank_id = 'hash_ewallet_id';
        $url = Helper::replace_uri_with_id(Config::ENDPOINT_BANK_EWALLET_REQUEST_OTP, $bank_id, '{bank_id}');
        $response = Request::post($url);
        $this->assertTrue($response->status() === 200);
        $this->assertEquals((new ParseResponse($response, $url))->getResponse(), $response->json());
    }

    public function testFailRequestOtpEwallet()
    {
        Config::$ACCESS_TOKEN = "ajklshdasdjals";

        $bank_id = 'hash_fail_ewallet_id';
        $url = Helper::replace_uri_with_id(Config::ENDPOINT_BANK_EWALLET_REQUEST_OTP, $bank_id, '{bank_id}');
        $response = Request::post($url);

        $this->assertTrue($response->status() === 500);
        $this->expectException(MootaException::class);
        $this->assertEquals((new ParseResponse($response, $url))->getResponse(), $response->json());
    }

    public function testVerificationOtpEwallet()
    {
        Config::$ACCESS_TOKEN = "ajklshdasdjals";

        $bank_id = 'hash_verification_ewallet_id';

        $payload = [
            'otp_code' => '1234'
        ];

        $url = Helper::replace_uri_with_id(Config::ENDPOINT_BANK_EWALLET_VERIFICATION_OTP, $bank_id, '{bank_id}');
        $response = Request::post($url, $payload);

        $this->assertTrue($response->status() === 200);
        $this->assertEquals((new ParseResponse($response, $url))->getResponse(), $response->json());
    }

    public function testInvalidVerificationOtpEwallet()
    {
        Config::$ACCESS_TOKEN = "ajklshdasdjals";

        $bank_id = 'hash_verification_ewallet_id';

        $payload = [
            'otp_code' => '12345'
        ];

        $url = Helper::replace_uri_with_id(Config::ENDPOINT_BANK_EWALLET_VERIFICATION_OTP, $bank_id, '{bank_id}');
        $response = Request::post($url, $payload);

        $this->assertTrue($response->status() === 422);
        $this->expectException(MootaException::class);
        $this->assertEquals((new ParseResponse($response, $url))->getResponse(), $response->json());
    }
}
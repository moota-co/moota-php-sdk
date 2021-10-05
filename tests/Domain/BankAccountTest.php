<?php


namespace Test\Domain;


use Moota\Moota\Config\Moota;
use Moota\Moota\DTO\BankAccount\BankAccountEwalletOtpVerification;
use Moota\Moota\DTO\BankAccount\BankAccountStoreData;
use Moota\Moota\DTO\BankAccount\BankAccountUpdateData;
use Moota\Moota\Exception\MootaException;
use Moota\Moota\Helper\Helper;
use Moota\Moota\Response\ParseResponse;
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
        Moota::$ACCESS_TOKEN = "ajklshdasdjals";

        $response = Request::get(Moota::ENDPOINT_BANK_INDEX);

        $this->assertTrue($response->status() === 200);
        $this->assertEquals(
            $response->json()['data'],
            (new ParseResponse($response, Moota::ENDPOINT_BANK_INDEX))->getResponse()->getBankData()
        );
    }

    public function testStoreBankAccount()
    {
        Moota::$ACCESS_TOKEN = "ajklshdasdjals";

        $payload = new BankAccountStoreData([
            "corporate_id"=> "",
            "bank_type"=> Moota::BANK_TYPES[0], // list of bank type
            "username"=> "loream",  //for gojek and ovo fill with mobile phone number
            "password"=> "your password",
            "name_holder"=> "loream kasma",
            "account_number"=> "16899030",
            "is_active"=> true
        ]);

        $response = Request::post(Moota::ENDPOINT_BANK_STORE, $payload->toArray());
        $this->assertTrue($response->status() === 200);
        $this->assertEquals(
            $response->json(),
            (new ParseResponse($response, Moota::ENDPOINT_BANK_INDEX))->getResponse()->getBankData()
        );
    }

    public function testFailStoreBankAccountWithInvalidRequestPayload()
    {
        Moota::$ACCESS_TOKEN = "ajklshdasdjals";

        $payload = new BankAccountStoreData([
            "corporate_id"=> "",
            "bank_type"=> "B C A",
            "username"=> "loream",  //for gojek and ovo fill with mobile phone number
            "password"=> "your password",
            "name_holder"=> "loream kasma",
            "account_number"=> "16899030",
            "is_active"=> true
        ]);

        $response = Request::post(Moota::ENDPOINT_BANK_STORE, $payload->toArray());
        $this->assertTrue($response->status() === 422);
        $this->expectException(MootaException::class);
        (new ParseResponse($response, Moota::ENDPOINT_BANK_INDEX))->getResponse();
        $this->expectExceptionMessage('The given data was invalid.');
    }

    public function testUpdateBankAccount()
    {
        Moota::$ACCESS_TOKEN = "ajklshdasdjals";

        $payload = new BankAccountUpdateData([
            "bank_id" => "hashing_qwopejs_id",
            "username"=> "jhon",  //for gojek and ovo fill with mobile phone number
            "corporate_id"=> "",
            "bank_type"=> "",
            "password"=> "",
            "name_holder"=> "",
            "account_number"=> "",
        ]);
        $url = Helper::replace_uri_with_id(Moota::ENDPOINT_BANK_UPDATE, $payload->bank_id, '{bank_id}');
        $response = Request::put($url, array_filter($payload->toArray()));

        $this->assertTrue($response->status() === 200);
        $this->assertContains($payload->username, $response->json()['bank']);
    }

    public function testFailUpdateBankAccountWithWrongId()
    {
        Moota::$ACCESS_TOKEN = "ajklshdasdjals";

        $payload = new BankAccountUpdateData([
            "bank_id" => '1',
            "username"=> "jhon",  //for gojek and ovo fill with mobile phone number
            "corporate_id"=> "",
            "bank_type"=> "",
            "password"=> "",
            "name_holder"=> "",
            "account_number"=> "",
        ]);

        $url = Helper::replace_uri_with_id(Moota::ENDPOINT_BANK_UPDATE, $payload->bank_id, '{bank_id}');
        $response = Request::put($url, array_filter($payload->toArray()));

        $this->assertTrue($response->status() === 500);
        $this->expectException(MootaException::class);
        (new ParseResponse($response, $url))->getResponse();
        $this->expectExceptionMessage("Data tidak ditemukan");
    }

    public function testCanRefreshMutation()
    {
        Moota::$ACCESS_TOKEN = "ajklshdasdjals";

        $bank_id = 'hash_oqwjas_id';
        $url = Helper::replace_uri_with_id(Moota::ENDPOINT_BANK_REFRESH_MUTATION, $bank_id, '{bank_id}');
        $response = Request::post($url);

        $this->assertTrue($response->status() === 200);
        $this->assertEquals(['message' => 'OK'], $response->json());
    }

    public function testCanFailRefreshMutationWithBalanceNotEnough()
    {
        Moota::$ACCESS_TOKEN = "ajklshdasdjals";

        $bank_id = 'hash_aswj_id';
        $url = Helper::replace_uri_with_id(Moota::ENDPOINT_BANK_REFRESH_MUTATION, $bank_id, '{bank_id}');
        $response = Request::post($url);

        $this->assertTrue($response->status() === 422);
        $this->expectException(MootaException::class);
        $this->assertEquals((new ParseResponse($response, $url))->getResponse(), $response->json());
    }

    public function testDestroyBankAccount()
    {
        Moota::$ACCESS_TOKEN = "ajklshdasdjals";

        $bank_id = 'hash_kiusd_id';
        $url = Helper::replace_uri_with_id(Moota::ENDPOINT_BANK_DESTROY, $bank_id, '{bank_id}');
        $response = Request::post($url);

        $this->assertTrue($response->status() === 200);
        $this->assertEquals(['message' => 'OK'], $response->json());
    }

    public function testFailDestroyBankAccount()
    {
        Moota::$ACCESS_TOKEN = "ajklshdasdjals";

        $bank_id = 'hash_qweas_id';
        $url = Helper::replace_uri_with_id(Moota::ENDPOINT_BANK_DESTROY, $bank_id, '{bank_id}');
        $response = Request::post($url);

        $this->assertTrue($response->status() === 500);
        $this->expectException(MootaException::class);
        $this->assertEquals((new ParseResponse($response, $url))->getResponse(), $response->json());
    }

    public function testRequestOtpEwallet()
    {
        Moota::$ACCESS_TOKEN = "ajklshdasdjals";

        $bank_id = 'hash_ewallet_id';
        $url = Helper::replace_uri_with_id(Moota::ENDPOINT_BANK_EWALLET_REQUEST_OTP, $bank_id, '{bank_id}');
        $response = Request::post($url);
        $this->assertTrue($response->status() === 200);
        $this->assertEquals((new ParseResponse($response, $url))->getResponse(), $response->json());
    }

    public function testFailRequestOtpEwallet()
    {
        Moota::$ACCESS_TOKEN = "ajklshdasdjals";

        $bank_id = 'hash_fail_ewallet_id';
        $url = Helper::replace_uri_with_id(Moota::ENDPOINT_BANK_EWALLET_REQUEST_OTP, $bank_id, '{bank_id}');
        $response = Request::post($url);

        $this->assertTrue($response->status() === 500);
        $this->expectException(MootaException::class);
        $this->assertEquals((new ParseResponse($response, $url))->getResponse(), $response->json());
    }

    public function testVerificationOtpEwallet()
    {
        Moota::$ACCESS_TOKEN = "ajklshdasdjals";

        $payload = new BankAccountEwalletOtpVerification([
            'bank_id' => 'hash_verification_ewallet_id',
            'otp_code' => '1234'
        ]);

        $url = Helper::replace_uri_with_id(Moota::ENDPOINT_BANK_EWALLET_VERIFICATION_OTP, $payload->bank_id, '{bank_id}');
        $response = Request::post($url, $payload->toArray());

        $this->assertTrue($response->status() === 200);
        $this->assertEquals((new ParseResponse($response, $url))->getResponse(), $response->json());
    }

    public function testInvalidVerificationOtpEwallet()
    {
        Moota::$ACCESS_TOKEN = "ajklshdasdjals";


        $payload = new BankAccountEwalletOtpVerification([
            'bank_id' => 'hash_verification_ewallet_id',
            'otp_code' => '12345'
        ]);

        $url = Helper::replace_uri_with_id(Moota::ENDPOINT_BANK_EWALLET_VERIFICATION_OTP, $payload->bank_id, '{bank_id}');
        $response = Request::post($url, $payload->toArray());

        $this->assertTrue($response->status() === 422);
        $this->expectException(MootaException::class);
        $this->assertEquals((new ParseResponse($response, $url))->getResponse(), $response->json());
    }
}
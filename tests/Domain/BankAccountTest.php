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
use Test\server\GuzzleServer;

class BankAccountTest extends TestCase
{

    public function testGetListBankAccount()
    {
        Moota::$ACCESS_TOKEN = 'eyJ0eXAiOiJKV1QiLCJ...';

        $response = GuzzleServer::request('GET', Moota::ENDPOINT_BANK_INDEX);
        $this->assertTrue($response->getStatusCode() === 200);
        $this->assertArrayHasKey(
            'data',
            (new ParseResponse($response, Moota::ENDPOINT_BANK_INDEX))->getResponse()->getBankData()
        );
    }

    public function testStoreBankAccount()
    {
        Moota::$ACCESS_TOKEN = "ajklshdasdjals";

        $payload = new BankAccountStoreData(
             "",
            Moota::BANK_TYPES[0], // list of bank type
            "loream",  //for gojek and ovo fill with mobile phone number
            "your password",
            "loream kasma",
            "16899030",
            true
       );

        $response = GuzzleServer::request('POST',
            Moota::ENDPOINT_BANK_STORE,
            ['Authorization' => 'Bearer '. Moota::$ACCESS_TOKEN],
            $payload->toArray()
        );

        $this->assertTrue($response->getStatusCode() === 200);
        $this->assertArrayHasKey(
            'bank',
            (new ParseResponse($response, Moota::ENDPOINT_BANK_INDEX))->getResponse()->getBankData()
        );
    }

    public function testFailStoreBankAccountWithInvalidRequestPayload()
    {
        Moota::$ACCESS_TOKEN = "ajklshdasdjals";

        $payload = new BankAccountStoreData(
            "",
             "B C A",
            "loream",  //for gojek and ovo fill with mobile phone number
            "your password",
            "loream kasma",
            "16899030",
            true
        );

        $this->expectException(MootaException::class);
        $this->expectException(\GuzzleHttp\Exception\ClientException::class);

        $response = GuzzleServer::request('POST',
            Moota::ENDPOINT_BANK_STORE,
            ['Authorization' => 'Bearer '. Moota::$ACCESS_TOKEN],
            $payload->toArray()
        );

        (new ParseResponse($response, Moota::ENDPOINT_BANK_INDEX))->getResponse();
        $this->assertTrue($response->getStatusCode() === 422);
        $this->expectExceptionMessage('The given data was invalid.');
    }

    public function testUpdateBankAccount()
    {
        Moota::$ACCESS_TOKEN = "ajklshdasdjals";

        $payload = new BankAccountUpdateData(
            "hashing_qwopejs_id",
            "jhon",  //for gojek and ovo fill with mobile phone number
            "",
            "",
            "",
            "",
            ""
        );
        $uri = Helper::replace_uri_with_id(Moota::ENDPOINT_BANK_UPDATE, $payload->bank_id, '{bank_id}');
        $response = GuzzleServer::request('PUT',
            $uri,
            ['Authorization' => 'Bearer '. Moota::$ACCESS_TOKEN],
            array_filter($payload->toArray())
        );

        $this->assertTrue($response->getStatusCode() === 200);
        $response = (new ParseResponse($response, $uri))->getResponse();
        $this->assertContains($payload->username, $response['bank']);
    }

    public function testFailUpdateBankAccountWithWrongId()
    {
        Moota::$ACCESS_TOKEN = "ajklshdasdjals";

        $payload = new BankAccountUpdateData(
            '1',
            "jhon",  //for gojek and ovo fill with mobile phone number
            "",
            "",
            "",
            "",
            "",
        );

        $uri = Helper::replace_uri_with_id(Moota::ENDPOINT_BANK_UPDATE, $payload->bank_id, '{bank_id}');
        $this->expectException(MootaException::class);
        $this->expectException(\GuzzleHttp\Exception\ServerException::class);
        $this->expectExceptionMessage("Data tidak ditemukan");
        $this->expectExceptionCode(500);

        GuzzleServer::request('PUT',
            $uri,
            ['Authorization' => 'Bearer '. Moota::$ACCESS_TOKEN],
            array_filter($payload->toArray())
        );
    }

    public function testCanRefreshMutation()
    {
        Moota::$ACCESS_TOKEN = "ajklshdasdjals";

        $bank_id = 'hash_oqwjas_id';
        $uri = Helper::replace_uri_with_id(Moota::ENDPOINT_BANK_REFRESH_MUTATION, $bank_id, '{bank_id}');

        $response = GuzzleServer::request('POST',
            $uri,
            ['Authorization' => 'Bearer '. Moota::$ACCESS_TOKEN],
            []
        );

        $this->assertTrue($response->getStatusCode() === 200);
        $this->assertEquals(['message' => 'OK'], json_decode($response->getBody()->getContents(), true));
    }

    public function testCanFailRefreshMutationWithBalanceNotEnough()
    {
        Moota::$ACCESS_TOKEN = "ajklshdasdjals";

        $bank_id = 'hash_aswj_id';
        $uri = Helper::replace_uri_with_id(Moota::ENDPOINT_BANK_REFRESH_MUTATION, $bank_id, '{bank_id}');

        $this->expectExceptionCode(422);
        GuzzleServer::request('POST',
            $uri,
            ['Authorization' => 'Bearer '. Moota::$ACCESS_TOKEN],
            []
        );
    }

    public function testDestroyBankAccount()
    {
        Moota::$ACCESS_TOKEN = "ajklshdasdjals";

        $bank_id = 'hash_kiusd_id';
        $uri = Helper::replace_uri_with_id(Moota::ENDPOINT_BANK_DESTROY, $bank_id, '{bank_id}');
        $response = GuzzleServer::request('POST',
            $uri,
            ['Authorization' => 'Bearer '. Moota::$ACCESS_TOKEN],
            []
        );
        $this->assertTrue($response->getStatusCode() === 200);
    }

    public function testFailDestroyBankAccount()
    {
        Moota::$ACCESS_TOKEN = "ajklshdasdjals";

        $bank_id = 'hash_qweas_id';
        $uri = Helper::replace_uri_with_id(Moota::ENDPOINT_BANK_DESTROY, $bank_id, '{bank_id}');
        $this->expectException(MootaException::class);
        $this->expectException(\GuzzleHttp\Exception\ServerException::class);
        $this->expectExceptionCode(500);
        $response = GuzzleServer::request('POST',
            $uri,
            ['Authorization' => 'Bearer '. Moota::$ACCESS_TOKEN],
            []
        );
    }

    public function testRequestOtpEwallet()
    {
        Moota::$ACCESS_TOKEN = "ajklshdasdjals";

        $bank_id = 'hash_ewallet_id';
        $uri = Helper::replace_uri_with_id(Moota::ENDPOINT_BANK_EWALLET_REQUEST_OTP, $bank_id, '{bank_id}');
        $response = GuzzleServer::request('POST',
            $uri,
            ['Authorization' => 'Bearer '. Moota::$ACCESS_TOKEN],
            []
        );
        $this->assertTrue($response->getStatusCode() === 200);
    }

    public function testFailRequestOtpEwallet()
    {
        $this->markTestSkipped('TODO ::');
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

        $payload = new BankAccountEwalletOtpVerification(
            'hash_verification_ewallet_id',
            '1234'
       );

        $uri = Helper::replace_uri_with_id(Moota::ENDPOINT_BANK_EWALLET_VERIFICATION_OTP, $payload->bank_id, '{bank_id}');
        $response = GuzzleServer::request('POST',
            $uri,
            ['Authorization' => 'Bearer '. Moota::$ACCESS_TOKEN],
            $payload->toArray()
        );
        $this->assertTrue($response->getStatusCode() === 200);
    }

    public function testInvalidVerificationOtpEwallet()
    {
        $this->markTestSkipped('TODO ::');
        Moota::$ACCESS_TOKEN = "ajklshdasdjals";


        $payload = new BankAccountEwalletOtpVerification(
            'hash_verification_ewallet_id',
            '12345'
        );

        $url = Helper::replace_uri_with_id(Moota::ENDPOINT_BANK_EWALLET_VERIFICATION_OTP, $payload->bank_id, '{bank_id}');
        $response = Request::post($url, $payload->toArray());

        $this->assertTrue($response->status() === 422);
        $this->expectException(MootaException::class);
        $this->assertEquals((new ParseResponse($response, $url))->getResponse(), $response->json());
    }
}
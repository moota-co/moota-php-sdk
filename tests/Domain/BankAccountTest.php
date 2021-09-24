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
    //eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiJLWmZzZ200Z29kUiIsImp0aSI6IjQ0NTg3ZThiYzM4NTA1NzRiNWJlYjJjZmRlYTE3MmI3MDk1NWIxZjhkNTJhOTRlZWY4MGM5MTAzZjFmZjY5ZTk0NmVlNGQ0MjlhZTlhM2UyIiwiaWF0IjoxNjMyNDU2MzA1LjI0MDgyOSwibmJmIjoxNjMyNDU2MzA1LjI0MDgzMSwiZXhwIjoxNjYzOTkyMzA1LjIzNzA5Mywic3ViIjoiMSIsInNjb3BlcyI6WyJhcGkiXX0.UYJFOlnL4G4KZ2okxUwLNp2769u3O3k0Urhj84G9pU9lreq9L8-037wsWT79DHN-c1zUD1WBnoIEUS6o0q3aM5S-Ssi_roczmB-Ts2Yov_k02BqgW_oLRcbTarbbOhzzHyMHNP7vcI4QrYeyTzpJLo7Wd4Fn4jfhuqqFpLvW34QUxws3gUIQGVz8cKc12OmHlCLgN4N1Bz6hg5jaOMRycIiD03hGM4NazH4fMNDMddhKkbQw8QjnoNnNRnuf7bbLTR-LquyzLDVTT0YGMKH-Cbtu67hmYB9E2wwCimZUpUyM-Bir772BSi59nW66mPqslS1fO8IixlkWTH03hhNu_ninKFmCpH8ZTdkVnruCy9fPDsjAn2pXeSco3NTFnKQccpdCiCJzILyQMNSmSpicqJm3AgPIcdoIZH-La_7niSR5xlks4Ln9Tzu2y8rAgLBCrPK0rIaI9qnhMHX37HQgX7GS9auJM8QVVmePVmfCbG6qsNaoiv5NqJ6tvknK9ilhUNWrHpJvfDIIJYZOG8_sAILFY1DKWk-rm7AF2DiMeOVWIsyfXhmqgnQLDNHfxYjVNVsYO1VWKx2yT4x8ylnz82clGGSA8AO9Rfqj4sOHmxZjndfeW2EqNmHCLoMUFv6WtRLSX3Fjfz30JCX9_wKolMf642kBxdDIwBMx2xecP3Q
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
}
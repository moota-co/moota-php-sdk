<?php


namespace Test\Domain;

use Moota\Moota\Config\Moota;
use Moota\Moota\Domain\Topup;
use Moota\Moota\DTO\Topup\ManualConfirmationTopupData;
use Moota\Moota\Exception\MootaException;
use Moota\Moota\Helper\Helper;
use PHPUnit\Framework\TestCase;
use Test\Request;
use Test\server\ZttpServer;

class TopupTest extends TestCase
{
    public static function setUpBeforeClass(): void
    {
        ZttpServer::start();
    }

    public function testGetListPaymentMethod()
    {
        Moota::$ACCESS_TOKEN = 'abcdefghijklmnopqrstuvwxyz';

        $response = Request::get(Moota::ENDPOINT_PAYMENT_METHOD);

        $this->assertTrue($response->status() === 200);
        $this->assertEquals(
            $response->json(),
            (new \Moota\Moota\Response\ParseResponse($response, Moota::ENDPOINT_PAYMENT_METHOD))->getResponse()
        );
    }

    public function testGetListTopupPoint()
    {
        Moota::$ACCESS_TOKEN = 'abcdefghijklmnopqrstuvwxyz';

        $params = [
            'page' => 1
        ];

        $response = Request::get(Moota::ENDPOINT_TOPUP_INDEX, $params);

        $this->assertTrue($response->status() === 200);
        $this->assertEquals(
            $response->json()['data'],
            (new \Moota\Moota\Response\ParseResponse($response, Moota::ENDPOINT_TOPUP_INDEX))->getResponse()->getTopupData()
        );
    }

    public function testCreateTopupPoint()
    {
        Moota::$ACCESS_TOKEN = 'abcdefghijklmnopqrstuvwxyz';

        $amounts = Request::get(Moota::ENDPOINT_TOPUP_DENOM);
        $methods = Request::get(Moota::ENDPOINT_PAYMENT_METHOD);
        $amounts = $amounts->json();
        $methods = $methods->json();

        $payload = [
            'amount' => $amounts[0]['value'],
            'payment_method' => $methods[0]['methods'][0]['bank_type']
        ];

        $response = Request::post(Moota::ENDPOINT_TOPUP_STORE, $payload);
        $this->assertTrue($response->status() === 200);
        $this->assertEquals(
            $response->json(),
            (new \Moota\Moota\Response\ParseResponse($response, Moota::ENDPOINT_TOPUP_STORE))->getResponse()->getTopupData()
        );
    }

    public function testGetListAmountPoint()
    {
        Moota::$ACCESS_TOKEN = 'abcdefghijklmnopqrstuvwxyz';

        $response = Request::get(Moota::ENDPOINT_TOPUP_DENOM);

        $this->assertTrue($response->status() === 200);
        $this->assertEquals(
            $response->json(),
            (new \Moota\Moota\Response\ParseResponse($response, Moota::ENDPOINT_TOPUP_DENOM))->getResponse()
        );
    }

    /**
     * WIP
     */
    public function testTopupPointManualConfirmation()
    {
        $this->markTestSkipped();
//        Moota::$ACCESS_TOKEN = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiJLWmZzZ200Z29kUiIsImp0aSI6IjQ0NTg3ZThiYzM4NTA1NzRiNWJlYjJjZmRlYTE3MmI3MDk1NWIxZjhkNTJhOTRlZWY4MGM5MTAzZjFmZjY5ZTk0NmVlNGQ0MjlhZTlhM2UyIiwiaWF0IjoxNjMyNDU2MzA1LjI0MDgyOSwibmJmIjoxNjMyNDU2MzA1LjI0MDgzMSwiZXhwIjoxNjYzOTkyMzA1LjIzNzA5Mywic3ViIjoiMSIsInNjb3BlcyI6WyJhcGkiXX0.UYJFOlnL4G4KZ2okxUwLNp2769u3O3k0Urhj84G9pU9lreq9L8-037wsWT79DHN-c1zUD1WBnoIEUS6o0q3aM5S-Ssi_roczmB-Ts2Yov_k02BqgW_oLRcbTarbbOhzzHyMHNP7vcI4QrYeyTzpJLo7Wd4Fn4jfhuqqFpLvW34QUxws3gUIQGVz8cKc12OmHlCLgN4N1Bz6hg5jaOMRycIiD03hGM4NazH4fMNDMddhKkbQw8QjnoNnNRnuf7bbLTR-LquyzLDVTT0YGMKH-Cbtu67hmYB9E2wwCimZUpUyM-Bir772BSi59nW66mPqslS1fO8IixlkWTH03hhNu_ninKFmCpH8ZTdkVnruCy9fPDsjAn2pXeSco3NTFnKQccpdCiCJzILyQMNSmSpicqJm3AgPIcdoIZH-La_7niSR5xlks4Ln9Tzu2y8rAgLBCrPK0rIaI9qnhMHX37HQgX7GS9auJM8QVVmePVmfCbG6qsNaoiv5NqJ6tvknK9ilhUNWrHpJvfDIIJYZOG8_sAILFY1DKWk-rm7AF2DiMeOVWIsyfXhmqgnQLDNHfxYjVNVsYO1VWKx2yT4x8ylnz82clGGSA8AO9Rfqj4sOHmxZjndfeW2EqNmHCLoMUFv6WtRLSX3Fjfz30JCX9_wKolMf642kBxdDIwBMx2xecP3Q';

        $topup_id = 'e42qjy2WGE5';
        $screenshot = dirname(__FILE__, '2') . '/Mocking/img/logo-icon.png';
        $screenshot = fopen($screenshot, 'r');
        $image = '';
        if ($screenshot!=false)
        {
            while (!feof($screenshot)) $image.=fgets($screenshot,1024);
            fclose($screenshot);
        }

        $url = Helper::replace_uri_with_id(Moota::ENDPOINT_TOPUP_CONFIRMATION, $topup_id, '{topup_id}');
        $topup = new Topup();

        $response = $topup->uploadFileTopupPointManualConfirmation(
            (new ManualConfirmationTopupData($topup_id, $screenshot))
        );

        $response = Request::postFile($url, (new ManualConfirmationTopupData($topup_id, $file))->toArray());
        $this->assertTrue($response->status() === 200);
    }

    public function testRedeemVoucher()
    {
        Moota::$ACCESS_TOKEN = 'abcdefghijklmnopqrstuvwxyz';

        $payload = [
            'code' => 'abcd'
        ];

        $response = Request::post(Moota::ENDPOINT_VOUCHER_REDEEM, $payload);

        $this->assertTrue($response->status() === 200);
        $this->assertEquals(
            $response->json(),
            (new \Moota\Moota\Response\ParseResponse($response, Moota::ENDPOINT_VOUCHER_REDEEM))->getResponse()
        );
    }

    public function testInvlidRedeemVoucher()
    {
        Moota::$ACCESS_TOKEN = 'abcdefghijklmnopqrstuvwxyz';

        $payload = [
            'code' => 'abcd-efgh'
        ];

        $response = Request::post(Moota::ENDPOINT_VOUCHER_REDEEM, $payload);

        $this->assertTrue($response->status() === 422);
        $this->expectException(MootaException::class);
        $this->assertEquals(
            $response->json(),
            (new \Moota\Moota\Response\ParseResponse($response, Moota::ENDPOINT_VOUCHER_REDEEM))->getResponse()
        );
    }
}
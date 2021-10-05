<?php


namespace Test\Domain;

use Moota\Moota\Config\Moota;
use Moota\Moota\Domain\Topup;
use Moota\Moota\DTO\Topup\CreateTopupData;
use Moota\Moota\DTO\Topup\ManualConfirmationTopupData;
use Moota\Moota\DTO\Topup\VoucherRedeemData;
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

        $payload = new CreateTopupData([
            'amount' => $amounts[0]['value'],
            'payment_method' => $methods[0]['methods'][0]['bank_type']
        ]);

        $response = Request::post(Moota::ENDPOINT_TOPUP_STORE, $payload->toArray());
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
        Moota::$ACCESS_TOKEN = 'abcdefghijklmnopqrstuvwxyz';

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

        $payload = new VoucherRedeemData([
            'code' => 'abcd'
        ]);

        $response = Request::post(Moota::ENDPOINT_VOUCHER_REDEEM, $payload->toArray());

        $this->assertTrue($response->status() === 200);
        $this->assertEquals(
            $response->json(),
            (new \Moota\Moota\Response\ParseResponse($response, Moota::ENDPOINT_VOUCHER_REDEEM))->getResponse()
        );
    }

    public function testInvlidRedeemVoucher()
    {
        Moota::$ACCESS_TOKEN = 'abcdefghijklmnopqrstuvwxyz';

        $payload = new VoucherRedeemData([
            'code' => 'abcd-efgh'
        ]);

        $response = Request::post(Moota::ENDPOINT_VOUCHER_REDEEM, $payload->toArray());

        $this->assertTrue($response->status() === 422);
        $this->expectException(MootaException::class);
        $this->assertEquals(
            $response->json(),
            (new \Moota\Moota\Response\ParseResponse($response, Moota::ENDPOINT_VOUCHER_REDEEM))->getResponse()
        );
    }
}
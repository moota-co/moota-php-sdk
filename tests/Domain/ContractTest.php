<?php
namespace Test\Domain;

use Moota\Moota\DTO\Contract\ContractStoreData;
use PHPUnit\Framework\TestCase;
use Moota\Moota\Config\Moota;
use Moota\Moota\DTO\Contract\ContractItemData;
use Moota\Moota\DTO\Contract\CustomerData;
use Moota\Moota\Response\ParseResponse;
use Test\Request;
use Test\server\ZttpServer;
use Moota\Moota\Exception\MootaException;


class ContractTest extends TestCase
{
    public static function setUpBeforeClass(): void
    {
        ZttpServer::start();
    }

    public function testStoreContract()
    {
        Moota::$ACCESS_TOKEN = "ajklshdasdjals...";

        $payload = new ContractStoreData([
            'invoice_number' => 'inv_moota_02',
            'amount'  => 40000,
            'payment_method_id' => '9Y8mjNZjeJ7',
            'payment_method_type'=> 'bank_transfer',
            'type' => 'payment',
            'callback_url' => 'https://moota.co/getresponse/callback',
            'increase_total_from_unique_code' => 1,
            'start_unique_code'=> 0,
            'end_unique_code'=> 999,
            'expired_date' => '2022-03-17 10:00:00',
            'description' => 'faktur',
            'customer' => new CustomerData([
                'name' => 'Customer Moota',
                'email' => 'customer@moota.co',
                'phone' => ''
            ]),
            'items'  => new ContractItemData([
                'name' => 'kaos warna putih',
                'sku' => 'sk-01',
                'price' => 20000,
                'qty' => 2,
                'image_url' => 'https://loreamipsum/storage/tshirt',
                'description' => '',
            ],[
                'name' => 'kaos warna hitam',
                'sku' => 'sk-01',
                'price' => 20000,
                'qty' => 2,
                'image_url' => 'https://loreamipsum/storage/tshirt',
                'description' => '',
            ]),
        ]);
      
        $response = Request::post(Moota::ENDPOINT_CONTRACT_STORE, $payload->toArray());
       
        $this->assertTrue($response->status() === 200);
        $this->assertEquals(
            $response->json()['data'],
            (new ParseResponse($response, Moota::ENDPOINT_CONTRACT_STORE))->getResponse()->getContractData()
        );
    }

    public function testFailStoreContractWithExistInvoiceNumber()
    {
        Moota::$ACCESS_TOKEN = "ajklshdasdjals...";

        $payload = new ContractStoreData([
            'invoice_number' => 'inv_moota_01',
            'amount'  => 40000,
            'payment_method_id' => '9Y8mjNZjeJ7',
            'payment_method_type'=> 'bank_transfer',
            'type' => 'payment',
            'callback_url' => 'https://moota.co/getresponse/callback',
            'increase_total_from_unique_code' => 1,
            'start_unique_code'=> 0,
            'end_unique_code'=> 999,
            'expired_date' => '2022-03-17 10:00:00',
            'description' => 'faktur',
        ]);
       
        $response = Request::post(Moota::ENDPOINT_CONTRACT_STORE, $payload->toArray());
       
        $this->assertTrue($response->status() === 422);
        $this->expectException(MootaException::class);
        (new ParseResponse($response, Moota::ENDPOINT_BANK_INDEX))->getResponse();
        $this->expectExceptionMessage('The given data was invalid.');
    }
}
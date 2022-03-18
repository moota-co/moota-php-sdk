<?php


namespace Test\Domain;

use Moota\Moota\DTO\Contract\ContractStoreData;
use Moota\Moota\Config\Moota;
use Moota\Moota\Domain\Contract;
use Moota\Moota\DTO\Contract\ContractItemData;
use Moota\Moota\DTO\Contract\CustomerData;
use PHPUnit\Framework\TestCase;
use Test\server\GuzzleServer;

class ContractTest extends TestCase
{
    public function testStoreContract()
    {
        Moota::$ACCESS_TOKEN = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9..';

        $items = [
            [
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
            ]
        ];

        $itemsContract = [];

        foreach($items as $item) {
            $itemsContract[] = new ContractItemData($item);
        }
      
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
            'customer' => new CustomerData([
                'name' => 'Customer Moota',
                'email' => 'customer@moota.co',
                'phone' => ''
            ]),
            'items'  => $itemsContract,
        ]);
        
        $response = GuzzleServer::request('POST', Moota::ENDPOINT_CONTRACT_STORE, ['Authorization' => 'Bearer '. Moota::$ACCESS_TOKEN], $payload->toArray());
        $this->assertTrue($response->getStatusCode() === 200);
      
        $parseResponse = (new \Moota\Moota\Response\ParseResponse($response, Moota::ENDPOINT_CONTRACT_STORE))
            ->getResponse()
            ->getContractData();
        
        $this->assertIsArray($parseResponse);
    }

    public function testFailStoreContractWithExistInvoiceNumber()
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
        ]);

    
        try{
            $response = GuzzleServer::request('POST', Moota::ENDPOINT_CONTRACT_STORE, ['Authorization' => 'Bearer '. Moota::$ACCESS_TOKEN], $payload->toArray());
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $response = $e->getResponse();
            $this->assertTrue($e->getCode() === 422);
        }
      
    }
}
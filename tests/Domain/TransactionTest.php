<?php


namespace Test\Domain;

use Moota\Moota\Config\Moota;
use Moota\Moota\DTO\Transaction\TransactionHistoryData;
use PHPUnit\Framework\TestCase;
use Test\Request;
use Test\server\ZttpServer;

class TransactionTest extends TestCase
{
    public static function setUpBeforeClass(): void
    {
        ZttpServer::start();
    }

    public function testGetHistoryTransactionPoint()
    {
        Moota::$ACCESS_TOKEN = 'abcdefghijklmnopqrstuvwxyz';

        $query_param = new TransactionHistoryData([
            'page' => 1,
            'start_date' => '',
            'end_date' => ''
        ]);

        $response = Request::get(Moota::ENDPOINT_TRANSACTION_HISTORY, $query_param->toArray());

        $this->assertTrue($response->status() === 200);
        $this->assertEquals(
            $response->json()['data'],
            (new \Moota\Moota\Response\ParseResponse($response, Moota::ENDPOINT_TRANSACTION_HISTORY))->getResponse()->getHistoryTransactionData()
        );
    }
}
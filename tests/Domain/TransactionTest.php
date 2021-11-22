<?php


namespace Test\Domain;

use Moota\Moota\Config\Moota;
use Moota\Moota\DTO\Transaction\TransactionHistoryData;
use PHPUnit\Framework\TestCase;
use Test\Request;
use Test\server\GuzzleServer;

class TransactionTest extends TestCase
{
    public function testGetHistoryTransactionPoint()
    {
        $this->markTestSkipped('TODO ::');

        Moota::$ACCESS_TOKEN = 'abcdefghijklmnopqrstuvwxyz';

        $query_param = new TransactionHistoryData( 1, '', '' );

        $response = Request::get(Moota::ENDPOINT_TRANSACTION_HISTORY, $query_param->toArray());

        $this->assertTrue($response->status() === 200);
        $this->assertEquals(
            $response->json()['data'],
            (new \Moota\Moota\Response\ParseResponse($response, Moota::ENDPOINT_TRANSACTION_HISTORY))->getResponse()->getHistoryTransactionData()
        );
    }
}
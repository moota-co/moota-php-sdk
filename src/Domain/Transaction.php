<?php

namespace Moota\Moota\Domain;

use GuzzleHttp\Client;
use Moota\Moota\Config\Moota;
use Moota\Moota\DTO\Transaction\TransactionHistoryData;
use Moota\Moota\Exception\MootaException;

class Transaction
{
    protected $client;

    protected array $headers = [];

    public function __construct()
    {
        $this->client = new Client(['base_uri' => Moota::BASE_URL]);
        $this->headers = [
            'User-Agent' => 'Moota/2.0',
            'Accept'     => 'application/json',
            'Authorization' => 'Bearer ' . Moota::$ACCESS_TOKEN
        ];
    }
    /**
     * Get History Points
     *
     * @throws MootaException
     */
    public function getHistoryTransactionPoint(TransactionHistoryData $historyTransactionData)
    {
        try {
            $response = $this->client->get(  Moota::ENDPOINT_TRANSACTION_HISTORY, [
                'headers' => $this->headers,
                'query' =>  $historyTransactionData->toArray()
            ]);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $response = $e->getResponse();
        } finally {
            return (new \Moota\Moota\Response\ParseResponse($response, Moota::ENDPOINT_TRANSACTION_HISTORY))->getResponse()->getHistoryTransactionData();
        }
    }
}
<?php
namespace Moota\Moota\Domain;

use Moota\Moota\DTO\Contract\ContractStoreData;
use Moota\Moota\Config\Moota;
use GuzzleHttp\Client;

class Contract
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

    public function storeContract(ContractStoreData $contractStoreData)
    {
        try {
            $response = $this->client->post(  Moota::ENDPOINT_CONTRACT_STORE, [
                'headers' => $this->headers,
                'json' => array_filter($contractStoreData->toArray())
            ]);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $response = $e->getResponse();
        } finally {
            return (new \Moota\Moota\Response\ParseResponse($response, Moota::ENDPOINT_CONTRACT_STORE))->getResponse()->getBankData();
        }
    }
}
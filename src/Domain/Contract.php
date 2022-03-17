<?php
namespace Moota\Moota\Domain;

use Moota\Moota\DTO\Contract\ContractStoreData;
use Moota\Moota\Config\Moota;
use Moota\Moota\Response\ParseResponse;
use Zttp\Zttp;

class Contract
{
    public function storeContract(ContractStoreData $contractStoreData)
    {
        $url = Moota::BASE_URL . Moota::ENDPOINT_CONTRACT_STORE;
      
        return (new ParseResponse(
            Zttp::withHeaders([
                'User-Agent'        => 'Moota/2.0',
                'Accept'            => 'application/json',
                'Authorization'     => 'Bearer ' . Moota::$ACCESS_TOKEN
            ])->post($url, $contractStoreData->toArray()), $url
        ))
            ->getResponse()
            ->getContractData();
    }
}

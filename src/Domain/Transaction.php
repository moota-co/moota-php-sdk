<?php

namespace Moota\Moota\Domain;

use Moota\Moota\Config\Moota;
use Moota\Moota\DTO\Transaction\TransactionHistoryData;
use Moota\Moota\Exception\MootaException;
use Moota\Moota\Response\ParseResponse;
use Moota\Moota\Response\Transaction\TransactionHistoryResponse;
use Zttp\Zttp;

class Transaction
{
    /**
     * Get History Points
     *
     * @throws MootaException
     */
    public function getHistoryTransactionPoint(TransactionHistoryData $historyTransactionData)
    {
        $url = Moota::BASE_URL . Moota::ENDPOINT_TRANSACTION_HISTORY;

        return (new ParseResponse(
            Zttp::withHeaders([
                'User-Agent'        => 'Moota/2.0',
                'Accept'            => 'application/json',
                'Authorization'     => 'Bearer ' . Moota::$ACCESS_TOKEN
            ])->get($url, $historyTransactionData->toArray()), $url
        ))
            ->getResponse()
            ->getHistoryTransactionData();
    }
}
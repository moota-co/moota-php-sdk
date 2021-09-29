<?php


namespace Moota\Moota\Response\Transaction;


class TransactionHistoryResponse
{
    private $history_transactions;

    public function __construct($results)
    {
        $this->history_transactions = $results['data'];
    }

    public function getHistoryTransactionData()
    {
        return $this->history_transactions;
    }
}
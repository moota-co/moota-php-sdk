<?php


namespace Moota\Moota\Response\BankAccount;


class BankAccountResponse
{
    private $bank_accounts;

    public function __construct($results)
    {
        $this->bank_accounts = $results;
    }

    public function getBankData()
    {
        return $this->bank_accounts;
    }
}
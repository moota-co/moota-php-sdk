<?php


namespace Moota\Moota\Response\BankAccount;


class BankAccountResponse
{
    private $bank_accounts;

    public function __construct($results)
    {
        if(isset($results['bank'])) {
            return $this->bank_accounts = $results;
        }
        $this->bank_accounts = $results['data'];
    }

    public function getBankData()
    {
        return $this->bank_accounts;
    }
}
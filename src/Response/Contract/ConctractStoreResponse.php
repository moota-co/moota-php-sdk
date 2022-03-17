<?php


namespace Moota\Moota\Response\Contract;


class ConctractStoreResponse
{
    private $contract;

    public function __construct($results)
    {
        if(isset($results['data'])) {
            return $this->contract = $results['data'];
        }
        $this->contract = $results;
    }

    public function getContractData()
    {
        return $this->contract;
    }
}
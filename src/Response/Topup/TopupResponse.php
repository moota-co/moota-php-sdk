<?php


namespace Moota\Moota\Response\Topup;


class TopupResponse
{
    private array $topups;

    public function __construct(array $results)
    {
        if(isset($results['data'])) {
            return $this->topups = $results['data'];
        }

        $this->topups = $results;
    }

    public function getTopupData()
    {
        return $this->topups;
    }
}
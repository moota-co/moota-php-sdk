<?php

namespace Moota\Moota\Domain;

use Moota\Moota\Request;

class Bank
{

    public function getBankList()
    {
        Request::request('GET', 'bank');
    }
}
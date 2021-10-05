<?php

namespace Moota\Moota\DTO\BankAccount;

use Spatie\DataTransferObject\DataTransferObject;

class BankAccountUpdateData extends DataTransferObject
{
    /** @var string */
    public $bank_id;
    /** @var string */
    public $corporate_id; // leave blank when non-corporate account bank example -> ''
    /** @var string */
    public $bank_type;
    /** @var string */
    public $username;
    /** @var string */
    public $password;
    /** @var string */
    public $name_holder;
    /** @var string */
    public $account_number;
    /** @var bool */
    public $is_active = true;
}
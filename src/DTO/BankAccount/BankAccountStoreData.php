<?php

namespace Moota\Moota\DTO\BankAccount;

use Spatie\DataTransferObject\DataTransferObject;

class BankAccountStoreData extends DataTransferObject
{
    public function __construct(
        public null|string $corporate_id, // leave blank when non-corporate account bank example -> ''
        public string $bank_type,
        public string $username,
        public string $password,
        public string $name_holder,
        public string $account_number,
        public bool $is_active = true
    ) { }
}
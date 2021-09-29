<?php

namespace Moota\Moota\DTO\Auth;

use Spatie\DataTransferObject\DataTransferObject;

class ScopesData extends DataTransferObject
{
    public function __construct(
        public bool $api = false,
        public bool $user = false,
        public bool $user_read = false,
        public bool $bank = false,
        public bool $bank_read = false,
        public bool $mutation = false,
        public bool $mutation_read = false,
    ){ }
}
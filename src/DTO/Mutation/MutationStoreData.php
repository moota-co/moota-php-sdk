<?php

namespace Moota\Moota\DTO\Mutation;

use Spatie\DataTransferObject\DataTransferObject;

class MutationStoreData extends DataTransferObject
{
    public function __construct(
            public string $bank_id,
            public string $date,
            public string $amount,
            public string $type = 'CR',
            public string $note = 'need debugging mutation dummy'
    ) { }
}
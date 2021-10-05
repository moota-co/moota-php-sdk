<?php

namespace Moota\Moota\DTO\Mutation;

use Spatie\DataTransferObject\DataTransferObject;

class MutationStoreData extends DataTransferObject
{
    /** @var string */
    public $bank_id;
    /** @var string */
    public $date;
    /** @var string */
    public $amount;
    /** @var string */
    public $type = 'CR';
    /** @var string */
    public $note = 'need debugging mutation dummy';
}
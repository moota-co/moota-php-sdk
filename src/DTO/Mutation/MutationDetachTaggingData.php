<?php

namespace Moota\Moota\DTO\Mutation;

use Spatie\DataTransferObject\DataTransferObject;

class MutationDetachTaggingData extends DataTransferObject
{
    /** @var string  */
    public $mutation_id;
    /** @var array */
    public $name;
}
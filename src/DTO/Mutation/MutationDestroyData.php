<?php

namespace Moota\Moota\DTO\Mutation;

use Spatie\DataTransferObject\DataTransferObject;

class MutationDestroyData extends DataTransferObject
{
    /** @var array  */
    public $mutations;
}
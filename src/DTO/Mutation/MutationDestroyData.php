<?php

namespace Moota\Moota\DTO\Mutation;

use Spatie\DataTransferObject\DataTransferObject;

class MutationDestroyData extends DataTransferObject
{
    public function __construct(
        public array $mutations
    ) { }
}
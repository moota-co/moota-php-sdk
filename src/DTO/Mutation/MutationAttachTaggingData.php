<?php

namespace Moota\Moota\DTO\Mutation;

use Spatie\DataTransferObject\DataTransferObject;

class MutationAttachTaggingData extends DataTransferObject
{
    public function __construct(
        public string $mutation_id,
        public array $name
    ) { }
}
<?php

namespace Moota\Moota\DTO\Mutation;

use Spatie\DataTransferObject\DataTransferObject;

class MutationNoteData extends DataTransferObject
{
    public function __construct(
        public string $mutation_id,
        public string $note
    ) { }
}
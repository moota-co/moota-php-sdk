<?php

namespace Moota\Moota\DTO\Mutation;

use Spatie\DataTransferObject\DataTransferObject;

class MutationNoteData extends DataTransferObject
{
    /** @var string */
    public $mutation_id;
    /** @var string */
    public $note;
}
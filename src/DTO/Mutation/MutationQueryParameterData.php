<?php

namespace Moota\Moota\DTO\Mutation;

use Spatie\DataTransferObject\DataTransferObject;

class MutationQueryParameterData extends DataTransferObject
{
    public function __construct(
        public null|string $type = '',
        public null|string $bank = '',
        public null|string $amount = '',
        public null|string $description = '',
        public null|string $note = '',
        public null|string $date = '',
        public null|string $start_date = '',
        public null|string $end_date = '',
        public null|string $tag = '',
        public int $page = 1,
        public int $per_page = 20,
    ) { }
}
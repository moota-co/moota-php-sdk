<?php

namespace Moota\Moota\DTO\Tagging;

use Spatie\DataTransferObject\DataTransferObject;

class TaggingStoreData extends DataTransferObject
{
    public function __construct(
        public string $name
    ) { }
}
<?php

namespace Moota\Moota\DTO\Tagging;

use Spatie\DataTransferObject\DataTransferObject;

class TaggingUpdateData extends DataTransferObject
{
    public function __construct(
        public string $tag_id,
        public string $name
    ) { }
}
<?php

namespace Moota\Moota\DTO\Tagging;

use Spatie\DataTransferObject\DataTransferObject;

class TaggingQueryParameterData extends DataTransferObject
{
    public function __construct(
        public array $tag = []
    ){ }
}
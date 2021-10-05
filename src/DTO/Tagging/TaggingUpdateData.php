<?php

namespace Moota\Moota\DTO\Tagging;

use Spatie\DataTransferObject\DataTransferObject;

class TaggingUpdateData extends DataTransferObject
{
    /** @var string  */
    public $tag_id;
    /** @var string */
    public $name;
}
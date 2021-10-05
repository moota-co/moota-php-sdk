<?php

namespace Moota\Moota\DTO\Mutation;

use Spatie\DataTransferObject\DataTransferObject;

class MutationQueryParameterData extends DataTransferObject
{
    /** @var string  */
    public $type = '';
    /** @var string  */
    public $bank = '';
    /** @var string  */
    public $amount = '';
    /** @var string  */
    public $description = '';
    /** @var string  */
    public $note = '';
    /** @var string  */
    public $date = '';
    /** @var string  */
    public $start_date = '';
    /** @var string  */
    public $end_date = '';
    /** @var string  */
    public $tag = '';
    /** @var int */
    public $page = 1;
    /** @var int  */
    public $per_page = 20;
}
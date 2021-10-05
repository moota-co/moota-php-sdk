<?php

namespace Moota\Moota\DTO\Auth;

use Spatie\DataTransferObject\DataTransferObject;

class ScopesData extends DataTransferObject
{
    /** @var bool  */
    public $api = false;
    /** @var bool  */
    public $user = false;
    /** @var bool  */
    public $user_read = false;
    /** @var bool  */
    public $bank = false;
    /** @var bool  */
    public $bank_read = false;
    /** @var bool  */
    public $mutation = false;
    /** @var bool  */
    public $mutation_read = false;
}
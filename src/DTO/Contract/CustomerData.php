<?php
namespace Moota\Moota\DTO\Contract;

use Spatie\DataTransferObject\DataTransferObject;

class CustomerData extends DataTransferObject
{
    /** @var string */
    public $name;
    /** @var string */
    public $email;
    /** @var string */
    public $phone = '';
}
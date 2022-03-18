<?php

namespace Moota\Moota\DTO\Contract;

use Spatie\DataTransferObject\DataTransferObject;

class CustomerData extends DataTransferObject
{
    public string $name;
    public string $email;
    public string $phone = '';
}
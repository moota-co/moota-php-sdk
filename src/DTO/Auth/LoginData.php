<?php

namespace Moota\Moota\DTO\Auth;

use Spatie\DataTransferObject\DataTransferObject;

class LoginData extends DataTransferObject
{
    public function __construct(
        public string $email,
        public string $password,
        public ScopesData $scopes
    ) { }
}
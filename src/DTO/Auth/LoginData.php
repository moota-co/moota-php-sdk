<?php

namespace Moota\Moota\DTO\Auth;

use Spatie\DataTransferObject\DataTransferObject;

class LoginData extends DataTransferObject
{
    /** @var string */
    public $email;
    /** @var string */
    public $password;
//    /** @var ScopesData */
    public $scopes;
}
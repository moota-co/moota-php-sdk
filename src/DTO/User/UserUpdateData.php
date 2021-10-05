<?php


namespace Moota\Moota\DTO\User;


use Spatie\DataTransferObject\DataTransferObject;

class UserUpdateData extends DataTransferObject
{
    /** @var string  */
    public $name;
    /** @var string */
    public $email = '';
    /** @var string  */
    public $no_ktp = '';
    /** @var string  */
    public $alamat = '';
}
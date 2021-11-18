<?php


namespace Moota\Moota\DTO\User;


use Spatie\DataTransferObject\DataTransferObject;

class UserUpdateData extends DataTransferObject
{
    public function __construct(
        public string $name,
        public ?string $email = null,
        public ?string $no_ktp = null,
        public ?string $alamat = null
    ) { }
}
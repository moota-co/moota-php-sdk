<?php


namespace Moota\Moota\DTO\Topup;


use Spatie\DataTransferObject\DataTransferObject;

class CreateTopupData extends DataTransferObject
{
    public function __construct(
        public int $amount,
        public string $payment_method
    ){ }
}
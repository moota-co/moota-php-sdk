<?php


namespace Moota\Moota\DTO\Topup;


use Spatie\DataTransferObject\DataTransferObject;

class VoucherRedeemData extends DataTransferObject
{
    public function __construct(
        public string $code
    ) { }
}
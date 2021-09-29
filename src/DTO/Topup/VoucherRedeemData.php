<?php


namespace Moota\Moota\DTO\Topup;


class VoucherRedeemData
{
    public function __construct(
        public string $code
    ) { }
}
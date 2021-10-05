<?php


namespace Moota\Moota\DTO\Topup;


use Spatie\DataTransferObject\DataTransferObject;

class VoucherRedeemData extends DataTransferObject
{
    /** @var string  */
    public $code;
}
<?php


namespace Moota\Moota\DTO\Topup;


use Spatie\DataTransferObject\DataTransferObject;

class CreateTopupData extends DataTransferObject
{
    /** @var int  */
    public $amount;
    /** @var string  */
    public $payment_method;
}
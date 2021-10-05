<?php

namespace Moota\Moota\DTO\BankAccount;

use Spatie\DataTransferObject\DataTransferObject;

class BankAccountEwalletOtpVerification extends DataTransferObject
{
    /** @var string  */
    public $bank_id;
    /** @var string  */
    public $otp_code;
}
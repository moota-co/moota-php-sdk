<?php

namespace Moota\Moota\DTO\BankAccount;

use Spatie\DataTransferObject\DataTransferObject;

class BankAccountEwalletOtpVerification extends DataTransferObject
{
    public function __construct(
        public string $bank_id,
        public string $otp_code
    ) { }
}
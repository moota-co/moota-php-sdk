<?php

namespace Test\DTO;

use PHPUnit\Framework\TestCase;

class BankAccountDataTransferObjectTest extends TestCase
{
    public function testBankAccountStoreDataTransferObject()
    {
        $BankAccountStoreData = new \Moota\Moota\DTO\BankAccount\BankAccountStoreData(
            null,
            'bca',
            "moota",  //for gojek and ovo fill with mobile phone number
            "moota_password",
            "moota.co",
            "16899030"
        );
        $this->assertInstanceOf(\Moota\Moota\DTO\BankAccount\BankAccountStoreData::class, $BankAccountStoreData);
    }

    public function testBankAccountUpdateDataTransferObject()
    {
        $BankAccountStoreData = new \Moota\Moota\DTO\BankAccount\BankAccountUpdateData(
            '<bank_id>',
            null,
            'bca',
            "moota",  //for gojek and ovo fill with mobile phone number
            "moota_password",
            "moota.co",
            "16899030",
            false
        );
        $this->assertInstanceOf(\Moota\Moota\DTO\BankAccount\BankAccountUpdateData::class, $BankAccountStoreData);
    }

    public function testBankAccountEwalletOtpVerification()
    {
        $BankAccountEwalletOtpVerification = new \Moota\Moota\DTO\BankAccount\BankAccountEwalletOtpVerification(
            '<bank_id>',
            '1234',
        );
        $this->assertInstanceOf(\Moota\Moota\DTO\BankAccount\BankAccountEwalletOtpVerification::class, $BankAccountEwalletOtpVerification);
    }
}
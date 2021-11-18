<?php

namespace Test\DTO;

use PHPUnit\Framework\TestCase;

class BankAccountDataTransferObjectTest extends TestCase
{
    public function testBankAccountStoreDataTransferObject()
    {
        $BankAccountStoreData = new \Moota\Moota\DTO\BankAccount\BankAccountStoreData(
            '',
            'bca',
            'moota',
            'password_ibanking',
            '121111111',
            'moota.co'
        );

        $this->assertInstanceOf(\Moota\Moota\DTO\BankAccount\BankAccountStoreData::class, $BankAccountStoreData);
    }

    public function testBankAccountUpdateDataTransferObject()
    {
        $BankAccountStoreData = new \Moota\Moota\DTO\BankAccount\BankAccountUpdateData(
            "<bank_id>",
            "", // leave blank when non-corporate account bank example -> ''
            "bca",
            "moota",
            "moota_password",
            "moota.co",
            "11122222"
        );
        $this->assertInstanceOf(\Moota\Moota\DTO\BankAccount\BankAccountUpdateData::class, $BankAccountStoreData);
    }

    public function testBankAccountEwalletOtpVerification()
    {
        $BankAccountEwalletOtpVerification = new \Moota\Moota\DTO\BankAccount\BankAccountEwalletOtpVerification(
         '<bank_id>',
          '1234'
        );
        $this->assertInstanceOf(\Moota\Moota\DTO\BankAccount\BankAccountEwalletOtpVerification::class, $BankAccountEwalletOtpVerification);
    }
}
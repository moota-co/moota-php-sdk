<?php

namespace Test\DTO;

use PHPUnit\Framework\TestCase;

class BankAccountDataTransferObjectTest extends TestCase
{
    public function testBankAccountStoreDataTransferObject()
    {
        $BankAccountStoreData = new \Moota\Moota\DTO\BankAccount\BankAccountStoreData([
            'corporate_id' => '',
            'bank_type' => 'bca',
            'username' => 'moota',
            'password' => 'password_ibanking',
            'account_number' => '121111111',
            'name_holder' => 'moota.co'
        ]);
        $this->assertInstanceOf(\Moota\Moota\DTO\BankAccount\BankAccountStoreData::class, $BankAccountStoreData);
    }

    public function testBankAccountUpdateDataTransferObject()
    {
        $BankAccountStoreData = new \Moota\Moota\DTO\BankAccount\BankAccountUpdateData([
            "bank_id" => "<bank_id>",
            "corporate_id" => "", // leave blank when non-corporate account bank example -> ''
            "bank_type" => "bca",
            "username" => "moota",
            "password" => "moota_password",
            "name_holder" => "moota.co",
            "account_number" => "11122222"
        ]);
        $this->assertInstanceOf(\Moota\Moota\DTO\BankAccount\BankAccountUpdateData::class, $BankAccountStoreData);
    }

    public function testBankAccountEwalletOtpVerification()
    {
        $BankAccountEwalletOtpVerification = new \Moota\Moota\DTO\BankAccount\BankAccountEwalletOtpVerification([
         'bank_id' => '<bank_id>',
          'otp_code' => '1234',
        ]);
        $this->assertInstanceOf(\Moota\Moota\DTO\BankAccount\BankAccountEwalletOtpVerification::class, $BankAccountEwalletOtpVerification);
    }
}
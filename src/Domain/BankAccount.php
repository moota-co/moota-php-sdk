<?php

namespace Moota\Moota\Domain;

use Moota\Moota\Config\Moota;
use Moota\Moota\DTO\BankAccount\BankAccountEwalletOtpVerification;
use Moota\Moota\DTO\BankAccount\BankAccountStoreData;
use Moota\Moota\DTO\BankAccount\BankAccountUpdateData;
use Moota\Moota\Exception\MootaException;
use Moota\Moota\Helper\Helper;
use Moota\Moota\Response\BankAccount\BankAccountResponse;
use Moota\Moota\Response\ParseResponse;
use Zttp\Zttp;

class BankAccount
{
    /**
     * Get List Bank Account
     *
     * @return BankAccountResponse
     * @throws MootaException
     */
    public function getBankList()
    {
        $url = Moota::BASE_URL . Moota::ENDPOINT_BANK_INDEX;

        return (new ParseResponse(
            Zttp::withHeaders([
                'User-Agent'        => 'Moota/2.0',
                'Accept'            => 'application/json',
                'Authorization'     => 'Bearer ' . Moota::$ACCESS_TOKEN
            ])->get($url), $url
        ))
            ->getResponse()
            ->getBankData();
    }

    /**
     * Create new Bank Account
     *
     * @param BankAccountStoreData $bankAccountStoreData
     * @throws MootaException
     */
    public function storeBankAccount(BankAccountStoreData $bankAccountStoreData)
    {
        $url = Moota::BASE_URL . Moota::ENDPOINT_BANK_STORE;

        return (new ParseResponse(
            Zttp::withHeaders([
                'User-Agent'        => 'Moota/2.0',
                'Accept'            => 'application/json',
                'Authorization'     => 'Bearer ' . Moota::$ACCESS_TOKEN
            ])->post($url, array_filter($bankAccountStoreData->toArray())), $url
        ))
            ->getResponse()
            ->getBankData();
    }

    /**
     * Update Bank Account Information
     * @param BankAccountUpdateData
     * @throws MootaException
     */
    public function updateBankAccount(BankAccountUpdateData $bankAccountUpdateData)
    {
        $url = Helper::replace_uri_with_id(Moota::BASE_URL . Moota::ENDPOINT_BANK_UPDATE, $bankAccountUpdateData->bank_id, '{bank_id}');

        return (new ParseResponse(
            Zttp::withHeaders([
                'User-Agent'        => 'Moota/2.0',
                'Accept'            => 'application/json',
                'Authorization'     => 'Bearer ' . Moota::$ACCESS_TOKEN
            ])->post($url, array_filter($bankAccountUpdateData->toArray())), $url
        ))
            ->getResponse()
            ->getBankData();
    }

    /**
     * @param string $bank_id
     *
     * @return void
     * @throws MootaException
     */
    public function refreshMutation(string $bank_id)
    {
        $url = Helper::replace_uri_with_id(Moota::BASE_URL . Moota::ENDPOINT_BANK_REFRESH_MUTATION, $bank_id, '{bank_id}');

        return (new ParseResponse(
            Zttp::withHeaders([
                'User-Agent'        => 'Moota/2.0',
                'Accept'            => 'application/json',
                'Authorization'     => 'Bearer ' . Moota::$ACCESS_TOKEN
            ])->post($url), $url
        ))
            ->getResponse();
    }

    /**
     * @param string $bank_id
     * @return void
     * @throws MootaException
     */
    public function destroyBankAccount(string $bank_id)
    {
        $url = Helper::replace_uri_with_id(Moota::BASE_URL . Moota::ENDPOINT_BANK_DESTROY, $bank_id, '{bank_id}');

        return (new ParseResponse(
            Zttp::withHeaders([
                'User-Agent'        => 'Moota/2.0',
                'Accept'            => 'application/json',
                'Authorization'     => 'Bearer ' . Moota::$ACCESS_TOKEN
            ])->post($url), $url
        ))
            ->getResponse();
    }

    /**
     * @param string $bank_id
     *
     * @return void
     * @throws MootaException
     */
    public function bankEwalletRequestOTPCode(string $bank_id)
    {
        $url = Helper::replace_uri_with_id(Moota::BASE_URL . Moota::ENDPOINT_BANK_EWALLET_REQUEST_OTP, $bank_id, '{bank_id}');

        return (new ParseResponse(
            Zttp::withHeaders([
                'User-Agent'        => 'Moota/2.0',
                'Accept'            => 'application/json',
                'Authorization'     => 'Bearer ' . Moota::$ACCESS_TOKEN
            ])->post($url), $url
        ))
            ->getResponse();
    }

    /**
     * Activate Ewallet Account with verification OTP Code
     *
     * @param BankAccountEwalletOtpVerification $bankAccountEwalletOtpVerification
     * @throws MootaException
     */
    public function bankEwalletVerificationOTPCode(BankAccountEwalletOtpVerification $bankAccountEwalletOtpVerification)
    {
        $url = Helper::replace_uri_with_id(Moota::BASE_URL . Moota::ENDPOINT_BANK_EWALLET_REQUEST_OTP, $bankAccountEwalletOtpVerification->bank_id, '{bank_id}');

        return (new ParseResponse(
            Zttp::withHeaders([
                'User-Agent'        => 'Moota/2.0',
                'Accept'            => 'application/json',
                'Authorization'     => 'Bearer ' . Moota::$ACCESS_TOKEN
            ])->post($url, array_filter($bankAccountEwalletOtpVerification->except('bank_id')->toArray())), $url
        ))
            ->getResponse();
    }

}
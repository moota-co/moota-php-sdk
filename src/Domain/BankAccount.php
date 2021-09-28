<?php

namespace Moota\Moota\Domain;

use Moota\Moota\Config\Moota;
use Moota\Moota\Exception\MootaException;
use Moota\Moota\Helper\Helper;
use Moota\Moota\Response\BankAccount\BankAccountResponse;
use Moota\Moota\Response\ParseResponse;
use Zttp\Zttp;

class BankAccount
{
    /**
     * Get List Bank Account
     * @return BankAccountResponse
     * @throws MootaException
     */
    public function getBankList(): BankAccountResponse
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

    public function storeBankAccount(array $payload)
    {
        $url = Moota::BASE_URL . Moota::ENDPOINT_BANK_STORE;

        return (new ParseResponse(
            Zttp::withHeaders([
                'User-Agent'        => 'Moota/2.0',
                'Accept'            => 'application/json',
                'Authorization'     => 'Bearer ' . Moota::$ACCESS_TOKEN
            ])->post($url, $payload), $url
        ))
            ->getResponse()
            ->getBankData();
    }

    /**
     * @param string $bank_id
     * @param array $payload
     * @return BankAccountResponse
     * @throws MootaException
     */
    public function updateBankAccount(string $bank_id, array $payload)
    {
        $url = Helper::replace_uri_with_id(Moota::BASE_URL . Moota::ENDPOINT_BANK_UPDATE, $bank_id, '{bank_id}');

        return (new ParseResponse(
            Zttp::withHeaders([
                'User-Agent'        => 'Moota/2.0',
                'Accept'            => 'application/json',
                'Authorization'     => 'Bearer ' . Moota::$ACCESS_TOKEN
            ])->post($url, $payload), $url
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
     * @param string $bank_id
     * @param array $payload
     *
     * @return void
     * @throws MootaException
     */
    public function bankEwalletVerificationOTPCode(string $bank_id, array $payload)
    {
        $url = Helper::replace_uri_with_id(Moota::BASE_URL . Moota::ENDPOINT_BANK_EWALLET_REQUEST_OTP, $bank_id, '{bank_id}');

        return (new ParseResponse(
            Zttp::withHeaders([
                'User-Agent'        => 'Moota/2.0',
                'Accept'            => 'application/json',
                'Authorization'     => 'Bearer ' . Moota::$ACCESS_TOKEN
            ])->post($url, $payload), $url
        ))
            ->getResponse();
    }

}
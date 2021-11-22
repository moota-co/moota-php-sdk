<?php

namespace Moota\Moota\Domain;

use GuzzleHttp\Client;
use Moota\Moota\Config\Moota;
use Moota\Moota\DTO\BankAccount\BankAccountEwalletOtpVerification;
use Moota\Moota\DTO\BankAccount\BankAccountStoreData;
use Moota\Moota\DTO\BankAccount\BankAccountUpdateData;
use Moota\Moota\Exception\MootaException;
use Moota\Moota\Helper\Helper;
use Moota\Moota\Response\BankAccount\BankAccountResponse;

class BankAccount
{
    protected $client;

    protected array $headers = [];

    public function __construct()
    {
        $this->client = new Client(['base_uri' => Moota::BASE_URL]);
        $this->headers = [
            'User-Agent' => 'Moota/2.0',
            'Accept'     => 'application/json',
            'Authorization' => 'Bearer ' . Moota::$ACCESS_TOKEN
        ];
    }

    /**
     * Get List Bank Account
     *
     * @return BankAccountResponse
     * @throws MootaException
     */
    public function getBankList(): BankAccountResponse
    {
        try {
            $response = $this->client->get(  Moota::ENDPOINT_BANK_INDEX, [
                'headers' => $this->headers,
                'json' => []
            ]);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $response = $e->getResponse();
        } finally {
            return (new \Moota\Moota\Response\ParseResponse($response, Moota::ENDPOINT_BANK_INDEX))->getResponse()->getBankData();
        }
    }

    /**
     * Create new Bank Account
     *
     * @param BankAccountStoreData $bankAccountStoreData
     * @throws MootaException
     */
    public function storeBankAccount(BankAccountStoreData $bankAccountStoreData)
    {
        try {
            $response = $this->client->post(  Moota::ENDPOINT_BANK_STORE, [
                'headers' => $this->headers,
                'json' => array_filter($bankAccountStoreData->toArray())
            ]);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $response = $e->getResponse();
        } finally {
            return (new \Moota\Moota\Response\ParseResponse($response, Moota::ENDPOINT_BANK_STORE))->getResponse()->getBankData();
        }
    }

    /**
     * Update Bank Account Information
     * @param BankAccountUpdateData
     * @throws MootaException
     */
    public function updateBankAccount(BankAccountUpdateData $bankAccountUpdateData)
    {
        $uri = Helper::replace_uri_with_id( Moota::ENDPOINT_BANK_UPDATE, $bankAccountUpdateData->bank_id, '{bank_id}');
        try {
            $response = $this->client->post(  $uri, [
                'headers' => $this->headers,
                'json' => array_filter($bankAccountUpdateData->toArray())
            ]);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $response = $e->getResponse();
        } finally {
            return (new \Moota\Moota\Response\ParseResponse($response, $uri))->getResponse()->getBankData();
        }
    }

    /**
     * @param string $bank_id
     *
     * @return void
     * @throws MootaException
     */
    public function refreshMutation(string $bank_id)
    {
        $uri = Helper::replace_uri_with_id( Moota::ENDPOINT_BANK_REFRESH_MUTATION, $bank_id, '{bank_id}');

        try {
            $response = $this->client->post(  $uri, [
                'headers' => $this->headers,
                'json' => []
            ]);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $response = $e->getResponse();
        } finally {
            return (new \Moota\Moota\Response\ParseResponse($response, $uri))->getResponse();
        }
    }

    /**
     * @param string $bank_id
     * @return void
     * @throws MootaException
     */
    public function destroyBankAccount(string $bank_id)
    {
        $uri = Helper::replace_uri_with_id( Moota::ENDPOINT_BANK_DESTROY, $bank_id, '{bank_id}');

        try {
            $response = $this->client->post(  $uri, [
                'headers' => $this->headers,
                'json' => []
            ]);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $response = $e->getResponse();
        } finally {
            return (new \Moota\Moota\Response\ParseResponse($response, $uri))->getResponse();
        }
    }

    /**
     * @param string $bank_id
     *
     * @return void
     * @throws MootaException
     */
    public function bankEwalletRequestOTPCode(string $bank_id)
    {
        $uri = Helper::replace_uri_with_id(Moota::ENDPOINT_BANK_EWALLET_REQUEST_OTP, $bank_id, '{bank_id}');

        try {
            $response = $this->client->post(  $uri, [
                'headers' => $this->headers,
                'json' => []
            ]);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $response = $e->getResponse();
        } finally {
            return (new \Moota\Moota\Response\ParseResponse($response, $uri))->getResponse();
        }
    }

    /**
     * Activate Ewallet Account with verification OTP Code
     *
     * @param BankAccountEwalletOtpVerification $bankAccountEwalletOtpVerification
     * @throws MootaException
     */
    public function bankEwalletVerificationOTPCode(BankAccountEwalletOtpVerification $bankAccountEwalletOtpVerification)
    {
        $uri = Helper::replace_uri_with_id( Moota::ENDPOINT_BANK_EWALLET_REQUEST_OTP, $bankAccountEwalletOtpVerification->bank_id, '{bank_id}');

        try {
            $response = $this->client->post(  $uri, [
                'headers' => $this->headers,
                'json' => array_filter($bankAccountEwalletOtpVerification->except('bank_id')->toArray())
            ]);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $response = $e->getResponse();
        } finally {
            return (new \Moota\Moota\Response\ParseResponse($response, $uri))->getResponse();
        }
    }
}
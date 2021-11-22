<?php

namespace Moota\Moota\Domain;

use GuzzleHttp\Client;
use Moota\Moota\Config\Moota;
use Moota\Moota\DTO\Topup\CreateTopupData;
use Moota\Moota\DTO\Topup\ManualConfirmationTopupData;
use Moota\Moota\DTO\Topup\VoucherRedeemData;
use Moota\Moota\Exception\MootaException;
use Moota\Moota\Response\Topup\TopupResponse;

class Topup
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
     * Get list payment method | targeting bank account topup point
     *
     * @throws MootaException
     */
    public function getPaymentMethod()
    {
        try {
            $response = $this->client->get(  Moota::ENDPOINT_PAYMENT_METHOD, [
                'headers' => $this->headers,
            ]);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $response = $e->getResponse();
        } finally {
            return (new \Moota\Moota\Response\ParseResponse($response, Moota::ENDPOINT_PAYMENT_METHOD))->getResponse();
        }
    }

    /**
     * Get List Amounts Point | minimum and maximum point can topup
     *
     * @throws MootaException
     */
    public function getListAmountPoint()
    {
        try {
            $response = $this->client->get(  Moota::ENDPOINT_TOPUP_DENOM, [
                'headers' => $this->headers,
            ]);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $response = $e->getResponse();
        } finally {
            return (new \Moota\Moota\Response\ParseResponse($response, Moota::ENDPOINT_TOPUP_DENOM))->getResponse();
        }
    }

    /**
     * Get list topup
     *
     * @param int $page
     *
     * @return TopupResponse
     * @throws MootaException
     */
    public function getListTopupPoint(int $page = 1)
    {
        try {
            $response = $this->client->get(  Moota::ENDPOINT_TOPUP_INDEX, [
                'headers' => $this->headers,
                'query' => ['page' => $page]
            ]);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $response = $e->getResponse();
        } finally {
            return (new \Moota\Moota\Response\ParseResponse($response, Moota::ENDPOINT_TOPUP_INDEX))->getResponse()->getTopupData();
        }
    }

    /**
     * Create Topup Point
     *
     * @param CreateTopupData $createTopupData
     * @throws MootaException
     */
    public function createTopupPoint(CreateTopupData $createTopupData)
    {
        try {
            $response = $this->client->post(  Moota::ENDPOINT_TOPUP_STORE, [
                'headers' => $this->headers,
                'json' => $createTopupData->toArray()
            ]);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $response = $e->getResponse();
        } finally {
            return (new \Moota\Moota\Response\ParseResponse($response, Moota::ENDPOINT_TOPUP_STORE))->getResponse()->getTopupData();
        }
    }

    /**
     * Redeem Voucher for increase point
     *
     * @param VoucherRedeemData $voucherRedeemData
     * @return void
     * @throws MootaException
     */
    public function redeemVoucher(VoucherRedeemData $voucherRedeemData)
    {
        try {
            $response = $this->client->post(  Moota::ENDPOINT_VOUCHER_REDEEM, [
                'headers' => $this->headers,
                'json' =>['code' => $voucherRedeemData->code]
            ]);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $response = $e->getResponse();
        } finally {
            return (new \Moota\Moota\Response\ParseResponse($response, Moota::ENDPOINT_VOUCHER_REDEEM))->getResponse();
        }
    }

    /**
     * WIP
     *
     * @param ManualConfirmationTopupData $manualConfirmationTopupData
     * @return mixed
     * @throws MootaException
     */
    public function uploadFileTopupPointManualConfirmation(ManualConfirmationTopupData $manualConfirmationTopupData)
    {
        // TODO ::
    }


}
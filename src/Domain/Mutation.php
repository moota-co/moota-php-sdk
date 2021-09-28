<?php

namespace Moota\Moota\Domain;

use Moota\Moota\Config\Moota;
use Moota\Moota\Exception\MootaException;
use Moota\Moota\Helper\Helper;
use Moota\Moota\Response\MootaResponse;
use Moota\Moota\Response\ParseResponse;
use Zttp\Zttp;

class Mutation
{

    /**
     * @param array $params
     * @return mixed
     * @return MootaResponse
     * @throws MootaException
     */
    public function getMutations(array $params = [])
    {
        $url = Moota::BASE_URL . Moota::ENDPOINT_MUTATION_INDEX;

        return (new ParseResponse(
            Zttp::withHeaders([
                'User-Agent'        => 'Moota/2.0',
                'Accept'            => 'application/json',
                'Authorization'     => 'Bearer ' . Moota::$ACCESS_TOKEN
            ])->get($url, $params), $url
        ))
        ->getResponse()
        ->getData();
    }

    /**
     * @param string $bank_id
     * @param array $payload
     * @return ParseResponse
     * @throws MootaException
     */
    public function storeMutation(string $bank_id, array $payload)
    {
        $url = Moota::BASE_URL . Moota::ENDPOINT_MUTATION_STORE . $bank_id;

        return (new ParseResponse(
            Zttp::withHeaders([
                'User-Agent'        => 'Moota/2.0',
                'Accept'            => 'application/json',
                'Authorization'     => 'Bearer ' . Moota::$ACCESS_TOKEN
            ])->post($url, $payload), $url
        ))
        ->getResponse();
    }

    /**
     * @param string $mutation_id
     * @param array $payload
     * @return ParseResponse
     * @throws \Moota\Moota\Exception\Mutation\MutationException
     */
    public function addNoteMutation(string $mutation_id, array $payload)
    {
        $url = Helper::replace_uri_with_id(Moota::BASE_URL . Moota::ENDPOINT_MUTATION_NOTE, $mutation_id, '{mutation_id}');

        return (new ParseResponse(
            Zttp::withHeaders([
                'User-Agent'        => 'Moota/2.0',
                'Accept'            => 'application/json',
                'Authorization'     => 'Bearer ' . Moota::$ACCESS_TOKEN
            ])->post($url, $payload), $url
        ))
        ->getResponse();
    }

    /**
     * @param string $mutation_id
     * @throws \Moota\Moota\Exception\Mutation\MootaException
     */
    public function pushWebhookByMutation(string $mutation_id)
    {
        $url = Helper::replace_uri_with_id(Moota::BASE_URL . Moota::ENDPOINT_MUTATION_WEBHOOK_STORE, $mutation_id, '{mutation_id}');

        return (new ParseResponse(
            Zttp::withHeaders([
                'User-Agent'        => 'Moota/2.0',
                'Accept'            => 'application/json',
                'Authorization'     => 'Bearer ' . Moota::$ACCESS_TOKEN
            ])->post($url, []), $url
        ))
            ->getResponse();
    }

    /**
     * @param array $payload
     *
     * @return ParseResponse
     * @throws \Moota\Moota\Exception\Mutation\MutationException
     */
    public function destroyMutation(array $payload)
    {
        $url = Moota::BASE_URL . Moota::ENDPOINT_MUTATION_DESTROY;
        return (new ParseResponse(
            Zttp::withHeaders([
                'User-Agent'        => 'Moota/2.0',
                'Accept'            => 'application/json',
                'Authorization'     => 'Bearer ' . Moota::$ACCESS_TOKEN
            ])->post($url, $payload), $url
        ))
            ->getResponse();
    }

    public function attachTagMutation(string $mutation_id, array $payload)
    {
        $url = Helper::replace_uri_with_id(Moota::BASE_URL . Moota::ENDPOINT_ATTATCH_TAGGING_MUTATION, $mutation_id, '{mutation_id}');
        return (new ParseResponse(
            Zttp::withHeaders([
                'User-Agent'        => 'Moota/2.0',
                'Accept'            => 'application/json',
                'Authorization'     => 'Bearer ' . Moota::$ACCESS_TOKEN
            ])->post($url, $payload), $url
        ))
            ->getResponse();
    }

    public function detachTagMutation(string $mutation_id, array $payload)
    {
        $url = Helper::replace_uri_with_id(Moota::BASE_URL . Moota::ENDPOINT_DETACH_TAGGING_MUTATION, $mutation_id, '{mutation_id}');
        return (new ParseResponse(
            Zttp::withHeaders([
                'User-Agent'        => 'Moota/2.0',
                'Accept'            => 'application/json',
                'Authorization'     => 'Bearer ' . Moota::$ACCESS_TOKEN
            ])->delete($url, $payload), $url
        ))
            ->getResponse();
    }

    public function updateTagMutation(string $mutation_id, array $payload)
    {
        $url = Helper::replace_uri_with_id(Moota::BASE_URL . Moota::ENDPOINT_UPDATE_TAGGING_MUTATION, $mutation_id, '{mutation_id}');
        return (new ParseResponse(
            Zttp::withHeaders([
                'User-Agent'        => 'Moota/2.0',
                'Accept'            => 'application/json',
                'Authorization'     => 'Bearer ' . Moota::$ACCESS_TOKEN
            ])->put($url, $payload), $url
        ))
            ->getResponse();
    }
}
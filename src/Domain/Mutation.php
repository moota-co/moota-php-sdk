<?php

namespace Moota\Moota\Domain;

use Moota\Moota\Config;
use Moota\Moota\Helper\Helper;
use Moota\Moota\ParseResponse;
use Zttp\Zttp;

class Mutation
{

    /**
     * @param array $params
     * @return mixed
     * @return ParseResponse
     * @throws \Moota\Moota\Exception\Mutation\MootaException
     */
    public function getMutations(array $params = [])
    {
        $url = Config::BASE_URL . Config::ENDPOINT_MUTATION_INDEX;

        return (new ParseResponse(
            Zttp::withHeaders([
                'User-Agent'        => 'Moota/2.0',
                'Accept'            => 'application/json',
                'Authorization'     => 'Bearer ' . Config::$ACCESS_TOKEN
            ])->get($url, $params), $url
        ))
        ->getResponse()
        ->getData();
    }

    /**
     * @param string $bank_id
     * @param array $payload
     * @return ParseResponse
     * @throws \Moota\Moota\Exception\Mutation\MutationException
     */
    public function storeMutation(string $bank_id, array $payload)
    {
        $url = Config::BASE_URL . Config::ENDPOINT_MUTATION_STORE . $bank_id;

        return (new ParseResponse(
            Zttp::withHeaders([
                'User-Agent'        => 'Moota/2.0',
                'Accept'            => 'application/json',
                'Authorization'     => 'Bearer ' . Config::$ACCESS_TOKEN
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
        $url = Helper::replace_uri_with_id(Config::BASE_URL . Config::ENDPOINT_MUTATION_NOTE, $mutation_id, '{mutation_id}');

        return (new ParseResponse(
            Zttp::withHeaders([
                'User-Agent'        => 'Moota/2.0',
                'Accept'            => 'application/json',
                'Authorization'     => 'Bearer ' . Config::$ACCESS_TOKEN
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
        $url = Helper::replace_uri_with_id(Config::BASE_URL . Config::ENDPOINT_MUTATION_WEBHOOK_STORE, $mutation_id, '{mutation_id}');

        return (new ParseResponse(
            Zttp::withHeaders([
                'User-Agent'        => 'Moota/2.0',
                'Accept'            => 'application/json',
                'Authorization'     => 'Bearer ' . Config::$ACCESS_TOKEN
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
        $url = Config::BASE_URL . Config::ENDPOINT_MUTATION_DESTROY;
        return (new ParseResponse(
            Zttp::withHeaders([
                'User-Agent'        => 'Moota/2.0',
                'Accept'            => 'application/json',
                'Authorization'     => 'Bearer ' . Config::$ACCESS_TOKEN
            ])->post($url, $payload), $url
        ))
            ->getResponse();
    }

}
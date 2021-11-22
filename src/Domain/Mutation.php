<?php

namespace Moota\Moota\Domain;

use GuzzleHttp\Client;
use Moota\Moota\Config\Moota;
use Moota\Moota\DTO\Mutation\MutationAttachTaggingData;
use Moota\Moota\DTO\Mutation\MutationDestroyData;
use Moota\Moota\DTO\Mutation\MutationDetachTaggingData;
use Moota\Moota\DTO\Mutation\MutationNoteData;
use Moota\Moota\DTO\Mutation\MutationQueryParameterData;
use Moota\Moota\DTO\Mutation\MutationStoreData;
use Moota\Moota\DTO\Mutation\MutationUpdateTaggingData;
use Moota\Moota\Exception\MootaException;
use Moota\Moota\Exception\Mutation\MutationException;
use Moota\Moota\Helper\Helper;

class Mutation
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
     * Get List Mutation and filter with query parameter object
     *
     * @param MutationQueryParameterData $mutationQueryParameterData
     * @throws MootaException
     */
    public function getMutations(MutationQueryParameterData $mutationQueryParameterData)
    {
        try {
            $response = $this->client->get(  Moota::ENDPOINT_MUTATION_INDEX, [
                'headers' => $this->headers,
                'query' => array_filter($mutationQueryParameterData->toArray())
            ]);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $response = $e->getResponse();
        } finally {
            return (new \Moota\Moota\Response\ParseResponse($response, Moota::ENDPOINT_MUTATION_INDEX))->getResponse()->getData();
        }
    }

    /**
     * Determine dummy mutation for debugging
     *
     * @param MutationStoreData $mutationStoreData
     * @throws MootaException
     */
    public function storeMutation(MutationStoreData $mutationStoreData)
    {
        try {
            $response = $this->client->post(  Moota::ENDPOINT_MUTATION_STORE . $mutationStoreData->bank_id, [
                'headers' => $this->headers,
                'json' => $mutationStoreData->except('bank_id')->toArray()
            ]);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $response = $e->getResponse();
        } finally {
            return (new \Moota\Moota\Response\ParseResponse($response, Moota::ENDPOINT_MUTATION_STORE))->getResponse();
        }
    }

    /**
     * Add note mutation
     *
     * @param MutationNoteData $mutationNoteData
     * @throws MutationException
     */
    public function addNoteMutation(MutationNoteData $mutationNoteData)
    {
        try {
            $uri = Helper::replace_uri_with_id( Moota::ENDPOINT_MUTATION_NOTE, $mutationNoteData->mutation_id, '{mutation_id}');

            $response = $this->client->post(  $uri, [
                'headers' => $this->headers,
                'json' => $mutationNoteData->except('mutation_id')->toArray()
            ]);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $response = $e->getResponse();
        } finally {
            return (new \Moota\Moota\Response\ParseResponse($response, Moota::ENDPOINT_MUTATION_STORE))->getResponse();
        }
    }

    /**
     * Debugging | try getting mutation webhook from moota
     *
     * @param string $mutation_id
     * @throws MootaException
     */
    public function pushWebhookByMutation(string $mutation_id)
    {
        try {
            $uri = Helper::replace_uri_with_id(Moota::ENDPOINT_MUTATION_PUSH_WEBHOOK, $mutation_id, '{mutation_id}');

            $response = $this->client->post(  $uri, [
                'headers' => $this->headers,
                'json' => []
            ]);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $response = $e->getResponse();
        } finally {
            return (new \Moota\Moota\Response\ParseResponse($response, Moota::ENDPOINT_MUTATION_PUSH_WEBHOOK))->getResponse();
        }
    }

    /**
     * Multiple destroy mutation
     *
     * @param MutationDestroyData $mutationDestroyData
     * @throws MootaException
     */
    public function destroyMutation(MutationDestroyData $mutationDestroyData)
    {
        try {
            $response = $this->client->post(  Moota::ENDPOINT_MUTATION_DESTROY, [
                'headers' => $this->headers,
                'json' => $mutationDestroyData->toArray()
            ]);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $response = $e->getResponse();
        } finally {
            return (new \Moota\Moota\Response\ParseResponse($response, Moota::ENDPOINT_MUTATION_DESTROY))->getResponse();
        }
    }

    /**
     * Attach Mutation with tagging
     *
     * @param MutationAttachTaggingData $mutationAttachTaggingData
     * @throws MootaException
     */
    public function attachTagMutation(MutationAttachTaggingData $mutationAttachTaggingData)
    {
        try {
            $uri = Helper::replace_uri_with_id( Moota::ENDPOINT_ATTATCH_TAGGING_MUTATION, $mutationAttachTaggingData->mutation_id, '{mutation_id}');

            $response = $this->client->post( $uri, [
                'headers' => $this->headers,
                'json' => $mutationAttachTaggingData->except('mutation_id')->toArray()
            ]);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $response = $e->getResponse();
        } finally {
            return (new \Moota\Moota\Response\ParseResponse($response, Moota::ENDPOINT_ATTATCH_TAGGING_MUTATION))->getResponse();
        }
    }

    /**
     * Detach Mutation from tagging
     *
     * @param MutationDetachTaggingData $mutationDetachTaggingData
     * @throws MootaException
     */
    public function detachTagMutation(MutationDetachTaggingData $mutationDetachTaggingData)
    {
        try {
            $uri = Helper::replace_uri_with_id( Moota::ENDPOINT_DETACH_TAGGING_MUTATION, $mutationDetachTaggingData->mutation_id, '{mutation_id}');

            $response = $this->client->post( $uri, [
                'headers' => $this->headers,
                'json' => $mutationDetachTaggingData->except('mutation_id')->toArray()
            ]);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $response = $e->getResponse();
        } finally {
            return (new \Moota\Moota\Response\ParseResponse($response, Moota::ENDPOINT_DETACH_TAGGING_MUTATION))->getResponse();
        }
    }

    /**
     * Update tagging from mutation instead
     *
     * @param MutationUpdateTaggingData $mutationUpdateTaggingData
     * @throws MootaException
     */
    public function updateTagMutation(MutationUpdateTaggingData $mutationUpdateTaggingData)
    {
        try {
            $url = Helper::replace_uri_with_id(Moota::BASE_URL . Moota::ENDPOINT_UPDATE_TAGGING_MUTATION, $mutationUpdateTaggingData->mutation_id, '{mutation_id}');

            $response = $this->client->put( $uri, [
                'headers' => $this->headers,
                'json' => $mutationUpdateTaggingData->except('mutation_id')->toArray()
            ]);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $response = $e->getResponse();
        } finally {
            return (new \Moota\Moota\Response\ParseResponse($response, Moota::ENDPOINT_UPDATE_TAGGING_MUTATION))->getResponse();
        }
    }
}
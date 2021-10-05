<?php

namespace Moota\Moota\Domain;

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
use Moota\Moota\Response\ParseResponse;
use Zttp\Zttp;

class Mutation
{

    /**
     * Get List Mutation and filter with query parameter object
     *
     * @param MutationQueryParameterData $mutationQueryParameterData
     * @throws MootaException
     */
    public function getMutations(MutationQueryParameterData $mutationQueryParameterData)
    {
        $url = Moota::BASE_URL . Moota::ENDPOINT_MUTATION_INDEX;

        return (new ParseResponse(
            Zttp::withHeaders([
                'User-Agent'        => 'Moota/2.0',
                'Accept'            => 'application/json',
                'Authorization'     => 'Bearer ' . Moota::$ACCESS_TOKEN
            ])->get($url, array_filter($mutationQueryParameterData->toArray())), $url
        ))
        ->getResponse()->getData();
    }

    /**
     * Determine dummy mutation for debugging
     *
     * @param MutationStoreData $mutationStoreData
     * @throws MootaException
     */
    public function storeMutation(MutationStoreData $mutationStoreData)
    {
        $url = Moota::BASE_URL . Moota::ENDPOINT_MUTATION_STORE . $mutationStoreData->bank_id;

        return (new ParseResponse(
            Zttp::withHeaders([
                'User-Agent'        => 'Moota/2.0',
                'Accept'            => 'application/json',
                'Authorization'     => 'Bearer ' . Moota::$ACCESS_TOKEN
            ])->post($url, $mutationStoreData->except('bank_id')->toArray()), $url
        ))
        ->getResponse();
    }

    /**
     * Add note mutation
     *
     * @param MutationNoteData $mutationNoteData
     * @throws MutationException
     */
    public function addNoteMutation(MutationNoteData $mutationNoteData)
    {
        $url = Helper::replace_uri_with_id(Moota::BASE_URL . Moota::ENDPOINT_MUTATION_NOTE, $mutationNoteData->mutation_id, '{mutation_id}');

        return (new ParseResponse(
            Zttp::withHeaders([
                'User-Agent'        => 'Moota/2.0',
                'Accept'            => 'application/json',
                'Authorization'     => 'Bearer ' . Moota::$ACCESS_TOKEN
            ])->post($url, $mutationNoteData->except('mutation_id')->toArray()), $url
        ))
        ->getResponse();
    }

    /**
     * Debugging | try getting mutation webhook from moota
     *
     * @param string $mutation_id
     * @throws MootaException
     */
    public function pushWebhookByMutation(string $mutation_id)
    {
        $url = Helper::replace_uri_with_id(Moota::BASE_URL . Moota::ENDPOINT_MUTATION_PUSH_WEBHOOK, $mutation_id, '{mutation_id}');

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
     * Multiple destroy mutation
     *
     * @param MutationDestroyData $mutationDestroyData
     * @throws MootaException
     */
    public function destroyMutation(MutationDestroyData $mutationDestroyData)
    {
        $url = Moota::BASE_URL . Moota::ENDPOINT_MUTATION_DESTROY;

        return (new ParseResponse(
            Zttp::withHeaders([
                'User-Agent'        => 'Moota/2.0',
                'Accept'            => 'application/json',
                'Authorization'     => 'Bearer ' . Moota::$ACCESS_TOKEN
            ])->post($url, $mutationDestroyData->toArray()), $url
        ))
            ->getResponse();
    }

    /**
     * Attach Mutation with tagging
     *
     * @param MutationAttachTaggingData $mutationAttachTaggingData
     * @throws MootaException
     */
    public function attachTagMutation(MutationAttachTaggingData $mutationAttachTaggingData)
    {
        $url = Helper::replace_uri_with_id(Moota::BASE_URL . Moota::ENDPOINT_ATTATCH_TAGGING_MUTATION, $mutationAttachTaggingData->mutation_id, '{mutation_id}');
        return (new ParseResponse(
            Zttp::withHeaders([
                'User-Agent'        => 'Moota/2.0',
                'Accept'            => 'application/json',
                'Authorization'     => 'Bearer ' . Moota::$ACCESS_TOKEN
            ])->post($url, $mutationAttachTaggingData->except('mutation_id')->toArray()), $url
        ))
            ->getResponse();
    }

    /**
     * Detach Mutation from tagging
     *
     * @param MutationDetachTaggingData $mutationDetachTaggingData
     * @throws MootaException
     */
    public function detachTagMutation(MutationDetachTaggingData $mutationDetachTaggingData)
    {
        $url = Helper::replace_uri_with_id(Moota::BASE_URL . Moota::ENDPOINT_DETACH_TAGGING_MUTATION, $mutationDetachTaggingData->mutation_id, '{mutation_id}');
        return (new ParseResponse(
            Zttp::withHeaders([
                'User-Agent'        => 'Moota/2.0',
                'Accept'            => 'application/json',
                'Authorization'     => 'Bearer ' . Moota::$ACCESS_TOKEN
            ])->delete($url, $mutationDetachTaggingData->except('mutation_id')->toArray()), $url
        ))
            ->getResponse();
    }

    /**
     * Update tagging from mutation instead
     *
     * @param MutationUpdateTaggingData $mutationUpdateTaggingData
     * @throws MootaException
     */
    public function updateTagMutation(MutationUpdateTaggingData $mutationUpdateTaggingData)
    {
        $url = Helper::replace_uri_with_id(Moota::BASE_URL . Moota::ENDPOINT_UPDATE_TAGGING_MUTATION, $mutationUpdateTaggingData->mutation_id, '{mutation_id}');
        return (new ParseResponse(
            Zttp::withHeaders([
                'User-Agent'        => 'Moota/2.0',
                'Accept'            => 'application/json',
                'Authorization'     => 'Bearer ' . Moota::$ACCESS_TOKEN
            ])->put($url, $mutationUpdateTaggingData->except('mutation_id')->toArray()), $url
        ))
            ->getResponse();
    }
}
<?php


namespace Moota\Moota\Domain;


use GuzzleHttp\Client;
use Moota\Moota\Config\Moota;
use Moota\Moota\DTO\Tagging\TaggingQueryParameterData;
use Moota\Moota\DTO\Tagging\TaggingStoreData;
use Moota\Moota\DTO\Tagging\TaggingUpdateData;
use Moota\Moota\Exception\MootaException;
use Moota\Moota\Helper\Helper;

class Tagging
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
     * Get my tagging list
     *
     * @param TaggingQueryParameterData $taggingQueryParameterData
     * @throws MootaException
     */
    public function getTaggings(TaggingQueryParameterData $taggingQueryParameterData)
    {
        try {
            $response = $this->client->get(  Moota::ENDPOINT_TAGGING_INDEX, [
                'headers' => $this->headers,
                'query' => ['tag' => implode(",", $taggingQueryParameterData->toArray()) ]
            ]);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $response = $e->getResponse();
        } finally {
            return (new \Moota\Moota\Response\ParseResponse($response, Moota::ENDPOINT_TAGGING_INDEX))->getResponse()->getTaggingData();
        }
    }

    /**
     * Create new Tags
     *
     * @param TaggingStoreData $taggingStoreData
     * @throws MootaException
     */
    public function storeTagging(TaggingStoreData $taggingStoreData)
    {
        try {
            $response = $this->client->get(  Moota::ENDPOINT_TAGGING_STORE, [
                'headers' => $this->headers,
                'json' => $taggingStoreData->toArray()
            ]);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $response = $e->getResponse();
        } finally {
            return (new \Moota\Moota\Response\ParseResponse($response, Moota::ENDPOINT_TAGGING_STORE))->getResponse()->getTaggingData();
        }
    }

    /**
     * Update Tag
     *
     * @param TaggingUpdateData $taggingUpdateData
     * @throws MootaException
     */
    public function updateTagging(TaggingUpdateData $taggingUpdateData) 
    {
        try {
            $uri = Helper::replace_uri_with_id( Moota::ENDPOINT_TAGGING_UPDATE, $taggingUpdateData->tag_id, '{tag_id}');

            $response = $this->client->put(  $uri, [
                'headers' => $this->headers,
                'json' => $taggingUpdateData->except('tag_id')->toArray()
            ]);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $response = $e->getResponse();
        } finally {
            return (new \Moota\Moota\Response\ParseResponse($response, Moota::ENDPOINT_TAGGING_UPDATE))->getResponse();
        }
    }

    /**
     * @param string $tag_id
     *
     * @return void
     * @throws MootaException
     */
    public function destroyTagging(string $tag_id)
    {
        try {
            $uri = Helper::replace_uri_with_id(Moota::ENDPOINT_TAGGING_DESTROY, $tag_id, '{tag_id}');

            $response = $this->client->delete(  $uri, [
                'headers' => $this->headers,
            ]);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $response = $e->getResponse();
        } finally {
            return (new \Moota\Moota\Response\ParseResponse($response, Moota::ENDPOINT_TAGGING_DESTROY))->getResponse();
        }
    }
}
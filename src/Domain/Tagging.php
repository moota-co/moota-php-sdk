<?php


namespace Moota\Moota\Domain;


use Moota\Moota\Config\Moota;
use Moota\Moota\DTO\Tagging\TaggingQueryParameterData;
use Moota\Moota\DTO\Tagging\TaggingStoreData;
use Moota\Moota\DTO\Tagging\TaggingUpdateData;
use Moota\Moota\Exception\MootaException;
use Moota\Moota\Helper\Helper;
use Moota\Moota\Response\ParseResponse;
use Zttp\Zttp;

class Tagging
{
    /**
     * Get my tagging list
     *
     * @param TaggingQueryParameterData $taggingQueryParameterData
     * @throws MootaException
     */
    public function getTaggings(TaggingQueryParameterData $taggingQueryParameterData)
    {
        $url = Moota::BASE_URL . Moota::ENDPOINT_TAGGING_INDEX;

        return (new ParseResponse(
            Zttp::withHeaders([
                'User-Agent'        => 'Moota/2.0',
                'Accept'            => 'application/json',
                'Authorization'     => 'Bearer ' . Moota::$ACCESS_TOKEN
            ])->get($url, ['tag' => implode(",", $taggingQueryParameterData->toArray()) ]), $url
        ))
            ->getResponse()
            ->getTaggingData();
    }

    /**
     * Create new Tags
     *
     * @param TaggingStoreData $taggingStoreData
     * @throws MootaException
     */
    public function storeTagging(TaggingStoreData $taggingStoreData)
    {
        $url = Moota::BASE_URL . Moota::ENDPOINT_TAGGING_STORE;

        return (new ParseResponse(
            Zttp::withHeaders([
                'User-Agent'        => 'Moota/2.0',
                'Accept'            => 'application/json',
                'Authorization'     => 'Bearer ' . Moota::$ACCESS_TOKEN
            ])->post($url, $taggingStoreData->toArray()), $url
        ))
            ->getResponse()
            ->getTaggingData();
    }

    /**
     * Update Tag
     *
     * @param TaggingUpdateData $taggingUpdateData
     * @throws MootaException
     */
    public function updateTagging(TaggingUpdateData $taggingUpdateData) 
    {
        $url = Helper::replace_uri_with_id(Moota::BASE_URL . Moota::ENDPOINT_TAGGING_UPDATE, $taggingUpdateData->tag_id, '{tag_id}');

        return (new ParseResponse(
            Zttp::withHeaders([
                'User-Agent'        => 'Moota/2.0',
                'Accept'            => 'application/json',
                'Authorization'     => 'Bearer ' . Moota::$ACCESS_TOKEN
            ])->put($url, $taggingUpdateData->except('tag_id')->toArray()), $url
        ))
            ->getResponse();
    }

    /**
     * @param string $tag_id
     *
     * @return void
     * @throws MootaException
     */
    public function destroyTagging(string $tag_id)
    {
        $url = Helper::replace_uri_with_id(Moota::BASE_URL . Moota::ENDPOINT_TAGGING_DESTROY, $tag_id, '{tag_id}');

        return (new ParseResponse(
            Zttp::withHeaders([
                'User-Agent'        => 'Moota/2.0',
                'Accept'            => 'application/json',
                'Authorization'     => 'Bearer ' . Moota::$ACCESS_TOKEN
            ])->delete($url), $url
        ))
            ->getResponse();
    }
}
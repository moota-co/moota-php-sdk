<?php

namespace Moota\Moota\Domain;

use GuzzleHttp\Client;
use Moota\Moota\Config\Moota;
use Moota\Moota\DTO\User\UserUpdateData;
use Moota\Moota\Exception\MootaException;
use Moota\Moota\Response\ParseResponse;
use Moota\Moota\Response\User\UserResponse;
use Zttp\Zttp;

class User
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
     * Get User Profile
     *
     * @throws MootaException
     */
    public function getProfile()
    {
        try {
            $response = $this->client->get(  Moota::ENDPOINT_USER_PROFILE, [
                'headers' => $this->headers,
            ]);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $response = $e->getResponse();
        } finally {
            return (new \Moota\Moota\Response\ParseResponse($response, Moota::ENDPOINT_USER_PROFILE))->getResponse()->getProfileData();
        }
    }

    /**
     * Update your profile information
     *
     * @param UserUpdateData $userUpdateData
     * @return UserResponse
     * @throws MootaException
     */
    public function updateProfile(UserUpdateData $userUpdateData)
    {
        try {
            $response = $this->client->post(  Moota::ENDPOINT_USER_PROFILE_UPDATE, [
                'headers' => $this->headers,
                'json' => array_filter($userUpdateData->toArray())
            ]);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $response = $e->getResponse();
        } finally {
            return (new \Moota\Moota\Response\ParseResponse($response, Moota::ENDPOINT_USER_PROFILE_UPDATE))->getResponse()->getProfileData();
        }
    }
}
<?php

namespace Moota\Moota\Domain;

use Moota\Moota\Config\Moota;
use Moota\Moota\DTO\User\UserUpdateData;
use Moota\Moota\Exception\MootaException;
use Moota\Moota\Response\ParseResponse;
use Moota\Moota\Response\User\UserResponse;
use Zttp\Zttp;

class User
{
    /**
     * Get User Profile
     *
     * @throws MootaException
     */
    public function getProfile()
    {
        $url = Moota::BASE_URL . Moota::ENDPOINT_USER_PROFILE;

        return (new ParseResponse(
            Zttp::withHeaders([
                'User-Agent'        => 'Moota/2.0',
                'Accept'            => 'application/json',
                'Authorization'     => 'Bearer ' . Moota::$ACCESS_TOKEN
            ])->get($url), $url
        ))
            ->getResponse()
            ->getProfileData();
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
        $url = Moota::BASE_URL . Moota::ENDPOINT_USER_PROFILE_UPDATE;
        $paylod = array_filter($userUpdateData->toArray());

        return (new ParseResponse(
            Zttp::withHeaders([
                'User-Agent'        => 'Moota/2.0',
                'Accept'            => 'application/json',
                'Authorization'     => 'Bearer ' . Moota::$ACCESS_TOKEN
            ])->post($url, $paylod), $url
        ))
            ->getResponse()
            ->getProfileData();
    }
}
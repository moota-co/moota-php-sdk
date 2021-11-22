<?php


namespace Test\Domain;

use Moota\Moota\Config\Moota;
use Moota\Moota\DTO\User\UserUpdateData;
use PHPUnit\Framework\TestCase;
use Test\Request;
use Test\server\GuzzleServer;

class UserTest extends TestCase
{
    public function testGetUserProfile()
    {
        $this->markTestSkipped('TODO ::');

        Moota::$ACCESS_TOKEN = 'abcdefghijklmnopqrstuvwxyz';

        $response = Request::get(Moota::ENDPOINT_USER_PROFILE);
        $results = $response->json();
        unset($results['meta']);
        $this->assertTrue($response->status() === 200);
        $this->assertEquals(
            $results,
            (new \Moota\Moota\Response\ParseResponse($response, Moota::ENDPOINT_USER_PROFILE))->getResponse()->getProfileData()
        );
    }

    public function testUpdateUserProfile()
    {
        $this->markTestSkipped('TODO ::');

        Moota::$ACCESS_TOKEN = 'abcdefghijklmnopqrstuvwxyz';
        $payload = new UserUpdateData('moota','email@moota.co','12312312123123','Jl. street no 1' );

        $response = Request::post(Moota::ENDPOINT_USER_PROFILE_UPDATE, $payload->toArray());
        $results = $response->json();

        unset($results['user']['meta']);
        $this->assertTrue($response->status() === 200);
        $this->assertEquals(
            $results['user'],
            (new \Moota\Moota\Response\ParseResponse($response, Moota::ENDPOINT_USER_PROFILE_UPDATE))->getResponse()->getProfileData()
        );
    }
}
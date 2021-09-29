<?php


namespace Test\Domain;



use Moota\Moota\Config\Moota;
use Moota\Moota\Domain\User;
use Moota\Moota\DTO\User\UserUpdateData;
use PHPUnit\Framework\TestCase;
use Test\Request;
use Test\server\ZttpServer;

class UserTest extends TestCase
{
    public static function setUpBeforeClass(): void
    {
        ZttpServer::start();
    }

    public function testGetUserProfile()
    {
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
        Moota::$ACCESS_TOKEN = 'abcdefghijklmnopqrstuvwxyz';

        $response = Request::post(Moota::ENDPOINT_USER_PROFILE_UPDATE);
        $results = $response->json();
        unset($results['meta']);

        $this->assertTrue($response->status() === 200);
        $this->assertEquals(
            $results,
            (new \Moota\Moota\Response\ParseResponse($response, Moota::ENDPOINT_USER_PROFILE_UPDATE))->getResponse()->getProfileData()
        );
    }
}
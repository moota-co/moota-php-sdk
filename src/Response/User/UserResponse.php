<?php


namespace Moota\Moota\Response\User;


class UserResponse
{
    private array $user;

    public function __construct(array $results)
    {
        unset($results['meta']);

        if(! isset($results['user'])) {
            return $this->user = $results['user'];
        }

        $this->user = $results;
    }

    public function getProfileData(): array
    {
        return $this->user;
    }
}
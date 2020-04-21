<?php


namespace shop\services;


use shop\entities\User;
use shop\repositories\UserRepository;

class NetworkService
{
    /**
     * @var UserRepository
     */
    private UserRepository $users;

    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    public function auth($network, $identity)
    {
        if ($user = $this->users->findByNetworkIdentity($network, $identity))
            return $user;
        $user = User::signupByNetwork($network, $identity);
        $this->users->save($user);
        return $user;
    }

}
<?php


namespace shop\services;


use shop\entities\user\User;
use shop\repositories\UserRepository;

class NetworkService
{
    /**
     * @var UserRepository
     */
    private $users;

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

    public function attach($id, $network, $identity)
    {
        if ($user = $this->users->findByNetworkIdentity($network, $identity)) {
            throw new \DomainException('Соцсеть уже подключена');
        }
        $user = $this->users->get($id);
        $user->attachNetwork($network, $identity);
        $this->users->save($user);
    }

}
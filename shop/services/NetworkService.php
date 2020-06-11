<?php


namespace shop\services;


use shop\entities\user\Rbac;
use shop\entities\user\User;
use shop\repositories\UserRepository;

class NetworkService
{
    /**
     * @var UserRepository
     */
    private $users;
    /**
     * @var TransactionManager
     */
    private $transaction;
    /**
     * @var RoleManager
     */
    private $roles;

    public function __construct(UserRepository $users, TransactionManager $transaction, RoleManager $roles)
    {
        $this->users = $users;
        $this->transaction = $transaction;
        $this->roles = $roles;
    }

    public function auth($network, $identity)
    {
        if ($user = $this->users->findByNetworkIdentity($network, $identity))
            return $user;
        $user = User::signupByNetwork($network, $identity);
        $this->transaction->wrap(function () use ($user) {
            $this->users->save($user);
            $this->roles->assign($user->id, Rbac::ROLE_USER);
        });
        $this->users->save($user);
        return $user;
    }

    public function attach($id, $network, $identity)
    {
        if ($user = $this->users->findByNetworkIdentity($network, $identity)) {
            throw new \DomainException('Соцсеть уже подключена к текущему профилю.');
        }
        $user = $this->users->get($id);
        $user->attachNetwork($network, $identity);
        $this->users->save($user);
    }

}
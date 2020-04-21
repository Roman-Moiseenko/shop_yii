<?php


namespace shop\services;


use shop\entities\user\User;
use shop\forms\LoginForm;
use shop\repositories\UserRepository;

class AuthService
{
    /**
     * @var UserRepository
     */
    private $users;

    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    public function auth(LoginForm $form): User
    {
        /** @var User $user */
        $user = $this->users->getByUsernameEmail($form->username);
        if (!$user || !$user->isActive() || !$user->validatePassword($form->password)) {
            throw new \DomainException('Неверный логин или пароль');
        }
        return $user;
    }

}
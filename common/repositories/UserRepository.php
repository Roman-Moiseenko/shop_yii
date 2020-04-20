<?php


namespace common\repositories;


use common\entities\User;

class UserRepository
{

    public function get($id): User
    {
        return $this->getBy(['id' => $id]);
    }

    public function getByEmailConfirmToken($token): User
    {
        return $this->getBy(['verification_token' => $token]);
    }

    public function getByEmail($email): User
    {
        return $this->getBy(['email' => $email]);
    }

    public function getByPasswordResetToken($token): User
    {
        return $this->getBy(['password_reset_token' => $token]);
    }

    public function getByUsername($username): User
    {
        return $this->getBy(['username' => $username]);
    }
    public function existsByPasswordResetToken(string $token): bool
    {
        return (bool) User::findByPasswordResetToken($token);
    }

    public function save(User $user, $runValidation = true, $attributeNames = null): void
    {
        if (!$user->save($runValidation, $attributeNames)) {
            throw new \RuntimeException('Ошибка сохранения.');
        }
        //$this->dispatcher->dispatchAll($user->releaseEvents());
    }

    private function getBy(array $condition): User
    {
        if (!$user = User::findOne($condition)) {
            throw new NotFoundException('Пользователь не найден.');
        }
        return $user;
    }

}
<?php


namespace shop\repositories;


use shop\entities\user\Network;
use shop\entities\user\User;
use shop\repositories\NotFoundException;

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

    public function getByUsernameEmail($value):? User
    {
        return User::find()->andWhere(['or', ['username' => $value], ['email' => $value]])->one();
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

    public function findByNetworkIdentity($network, $identity)
    {
        return User::find()
            ->joinWith(Network::tableName() . ' n')
            ->andWhere(['n.identity' => $identity, 'n.network' => $network])
            ->one();

        /*if (!$network = Network::findOne(['identity' => $identity, 'network' => $network])) {
            return false;
        }
        if (!$user = User::findOne(['id' => $network->user_id])) {
            return false;
        }
        return $user;*/
    }

    private function getBy(array $condition): User
    {
        if (!$user = User::findOne($condition)) {
            throw new NotFoundException('Пользователь не найден.');
        }
        return $user;
    }

}
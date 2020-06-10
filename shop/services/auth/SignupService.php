<?php


namespace shop\services\auth;


use shop\entities\user\Rbac;
use shop\entities\user\User;
use shop\forms\auth\SignupForm;
use shop\repositories\UserRepository;
use shop\services\RoleManager;
use shop\services\TransactionManager;
use Yii;

class SignupService
{

    /**
     * @var RoleManager
     */
    private $roles;
    /**
     * @var TransactionManager
     */
    private $transaction;
    /**
     * @var UserRepository
     */
    private $users;

    public function __construct(
        UserRepository $users,
        RoleManager $roles,
        TransactionManager $transaction
    )
    {
        $this->roles = $roles;
        $this->transaction = $transaction;
        $this->users = $users;
    }

    public function signup(SignupForm $form): User
    {
        $user = User::signup($form->username, $form->email, $form->password);
        $this->transaction->wrap(function () use ($user) {
            $this->users->save($user);
            $this->roles->assign($user->id, Rbac::ROLE_USER);
        });

        if (!$this->sendEmail($user)) {
            throw new \RuntimeException('Ошибка отправки email.');
        }
        return $user;
    }

    private function sendEmail(User $user)
    {
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => 'Регистрация kupi41.ru'])
            ->setTo($user->email)
            ->setSubject('Account registration at ' . Yii::$app->name)
            ->send();
    }
}
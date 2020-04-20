<?php


namespace frontend\services\auth;


use common\entities\User;
use frontend\forms\ResendVerificationEmailForm;
use Yii;
use yii\base\InvalidArgumentException;

class VerificationService
{

    public function verifyEmail($token): User
    {
        $user = User::findByPasswordResetToken($token);
        if (!$user)
            throw new \DomainException('Пользователь не найден');
        if ($user->status === User::STATUS_ACTIVE)
            throw new \DomainException('Пользователь не активен');
        return $user;
    }

    public function VerificationEmail(ResendVerificationEmailForm $form): void
    {
        $user = User::findOne([
            'email' => $form->email,
            'status' => User::STATUS_INACTIVE
        ]);

        if ($user === null) {
            throw new \RuntimeException('Пользователь не найден');
        }

        $send = Yii::$app
            ->mailer
            ->compose(
                ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($user->email)
            ->setSubject('Account registration at ' . Yii::$app->name)
            ->send();
        if (!$send) {
            throw new \RuntimeException('Письмо не отправлено, проверьте правильность заполнения поля Email');
        }
    }
}
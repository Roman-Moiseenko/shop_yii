<?php


namespace frontend\services\auth;


use common\entities\User;
use frontend\forms\PasswordResetRequestForm;
use frontend\forms\ResendVerificationEmailForm;
use frontend\forms\ResetPasswordForm;
use Yii;
use yii\mail\MailerInterface;

class PasswordResetService
{
    private $supportEmail;
    /**
     * @var MailerInterface
     */
    private $mailer;

    public function __construct($supportEmail, MailerInterface $mailer)
    {
        $this->supportEmail = $supportEmail;
        $this->mailer = $mailer;
    }

    private function findByEmail($email): User
    {
        /* @var $user User */
        $user = User::findOne([
            'status' => User::STATUS_ACTIVE,
            'email' => $email,
        ]);

        if (!$user) {
            throw new \DomainException('Пользователь не найден');
        }
        return $user;
    }

    public function request(PasswordResetRequestForm $form)
    {
        /* @var $user User */
        $user = $this->findByEmail($form->email);

        $user->requestPasswordReset();
        if (!$user->save()) {
            throw new \RuntimeException('Ошибка сохранения');
        }

        $sent = $this->mailer
            ->compose(
                ['html' => 'passwordResetToken-html', 'text' => 'passwordResetToken-text'],
                ['user' => $user]
            )
            ->setFrom($this->supportEmail/*[Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot']*/)
            ->setTo($user->email)
            ->setSubject('Password reset for ' . $user->username)
            ->send();
        if (!$sent) {
            throw new \RuntimeException('Письмо не отправлено, проверьте правильность заполнения поля Email');
        }
    }

    public function verifyToken($token): void
    {
        if (empty($token) || !is_string($token)) {
            throw new \DomainException('Password reset token cannot be blank.');
        }
        if (!User::findByPasswordResetToken($token)) {
            echo $token;
            die();
            throw new \DomainException('Wrong password reset token.');
        }
    }

    public function validateToken($token): void
    {
        if (empty($token) || !is_string($token)) {
            throw new \DomainException('Password reset token cannot be blank.');
        }
        if (!User::findByPasswordResetToken($token)) {
            echo $token;
            die();
            throw new \DomainException('Wrong password reset token.');
        }
    }


    public function reset($token, ResetPasswordForm $form): void
    {
        $user = User::findByPasswordResetToken($token);
        if (!$user)
            throw new \DomainException('Пользователь не найден');
        $user->resetPassword($form->password);
        if (!$user->save(false)) {
            throw new \DomainException('Ошибка сброса пароля');
        }
    }
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
        $user = $this->findByEmail($form->email);

        $send =  $this->mailer
            ->compose(
                ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
                ['user' => $user]
            )
            ->setFrom($this->supportEmail)
            ->setTo($user->email)
            ->setSubject('Account registration at ' . $user->username)
            ->send();
        if (!$send) {
            throw new \RuntimeException('Письмо не отправлено, проверьте правильность заполнения поля Email');
        }
    }

}
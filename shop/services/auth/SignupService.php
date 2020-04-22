<?php


namespace shop\services\auth;


use shop\entities\user\User;
use shop\forms\auth\SignupForm;
use Yii;

class SignupService
{

    public function signup(SignupForm $form): User
    {
        $user = User::signup($form->username, $form->email, $form->password);
        if (!$user->save() || !$this->sendEmail($user)) {
            throw new \RuntimeException('Saving error');
        }
        return $user;
    }

    private function sendEmail(USer $user)
    {
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($user->email)
            ->setSubject('Account registration at ' . Yii::$app->name)
            ->send();
    }
}
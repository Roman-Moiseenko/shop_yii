<?php


namespace frontend\services\auth;


use frontend\forms\ContactForm;
use Yii;
use yii\mail\MailerInterface;

class ContactService
{

    /**
     * @var MailerInterface
     */
    private $mailer;
    private $supportEmail;
    private $adminEmail;

    public function __construct($supportEmail, $adminEmail, MailerInterface $mailer)
    {
        $this->mailer = $mailer;
        $this->supportEmail = $supportEmail;
        $this->adminEmail = $adminEmail;
    }

    public function contact(ContactForm $form): void
    {
        $send = $this->mailer->compose()
            ->setTo($this->adminEmail)
            ->setFrom($this->supportEmail)
            ->setReplyTo([$form->email => $form->name])
            ->setSubject($form->subject)
            ->setTextBody($form->body)
            ->send();
        if (!$send) {
            throw new \RuntimeException('Ошибка отправки');
        }
    }

}
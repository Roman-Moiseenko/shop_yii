<?php


namespace shop\services\auth;


use shop\entities\shop\order\Order;
use shop\forms\ContactForm;
use shop\helpers\OrderHelper;
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

    public function sendNoticeOrder(Order $order)
    {
        //TODO
        // В базе прописать адреса и номера для отправки данных, и в админке их менять
        // и прописать куда отправлять или нет
        $body = 'Заказ № ' . $order->id . '.  На сумму ' . $order->cost . '<br>' .
            ' Покупатель ' . ($order->user)->fullname->getFullname() . '<br>' .
            ' Телефон ' . ($order->user)->phone;
        $message = [
            'subject' => 'Новый заказ', 'body' => $body];
        //
        $sendNotice = ['email' => true, 'sms' => true, 'whatsapp' => true];
        if ($sendNotice['email']) $this->sendEMAILNoticeOrder($message);
        if ($sendNotice['sms']) $this->sendSMSNoticeOrder($message);
        if ($sendNotice['whatsapp']) $this->sendWHATSAPPNoticeOrder($message);
    }

    private function sendEMAILNoticeOrder(array $message)
    {
        $send = $this->mailer->compose()
            ->setTo($this->adminEmail)
            ->setFrom($this->supportEmail)
            //->setReplyTo()
            ->setSubject($message['subject'])
            ->setTextBody($message['body'])
            ->send();
        if (!$send) {
            throw new \RuntimeException('Ошибка отправки');
        }
    }

    private function sendSMSNoticeOrder(array $message)
    {
//TODO Сделать отправку СМС
    }

    private function sendWHATSAPPNoticeOrder(array $message)
    {
//TODO Сделать отправку WathApp или Telegram
    }

    public function ChangeStatus(Order $order)
    {
        $body = 'Новый статус - ' . OrderHelper::statusName($order->current_status) . '<br>' .
            'Заказ № ' . $order->id . '.  На сумму ' . $order->cost . '<br>' .
            ' Покупатель ' . ($order->user)->fullname->getFullname() . '<br>' .
            ' Телефон ' . ($order->user)->phone;
        $message = [
            'subject' => 'Изменение статуса заказа', 'body' => $body];
        //
        $sendNotice = ['email' => true, 'sms' => true, 'whatsapp' => true];
        if ($sendNotice['email']) $this->sendEMAILNoticeOrder($message);
        if ($sendNotice['sms']) $this->sendSMSNoticeOrder($message);
        if ($sendNotice['whatsapp']) $this->sendWHATSAPPNoticeOrder($message);
    }

}
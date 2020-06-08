<?php


namespace shop\services;


use shop\entities\shop\order\Order;
use shop\forms\ContactForm;
use shop\helpers\OrderHelper;
use shop\helpers\ParamsHelper;
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
            'Текущий статус ' . OrderHelper::statusName($order->current_status) . '<br>' .
            ' Покупатель ' . ($order->user)->fullname->getFullname() . '<br>' .
            ' Телефон ' . ($order->user)->phone;
        $message = [
            'subject' => 'Заказ ' . OrderHelper::statusName($order->current_status), 'body' => $body];
        //
        $sendNotice = ['email' => true, 'sms' => true, 'whatsapp' => true];
        if ($sendNotice['email']) $this->sendEMAILNoticeOrder($message);
        if ($sendNotice['sms']) $this->sendSMSNoticeOrder($message);
        if ($sendNotice['whatsapp']) $this->sendTELEGRAMNoticeOrder($message);

        //TODO отправка сообщения клиенту о статусе его заказа (email и SMS)
    }

    private function sendEMAILNoticeOrder(array $message)
    {
        if (!$email = ParamsHelper::get('emailOrder')) {
            $email  = $this->adminEmail;
        }

        $send = $this->mailer->compose()
            ->setTo($email)
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
//TODO Сделать отправку СМС через sms.ru
    }

    private function sendTELEGRAMNoticeOrder(array $message)
    {
//TODO Сделать отправку  Telegram
   \Yii::$app->telegram->sendMessage([
            'chat_id' => 371289480,
            'text' => $message['body'],
        ]);
       /* $ch = curl_init();
        curl_setopt_array(
            $ch,
            array(
                CURLOPT_URL => 'https://api.telegram.org/bot1108058298:AAFXEmclOx6MduA_pCXPOYVwNUPFVRT8Knc/sendMessage',
                CURLOPT_POST => TRUE,
                CURLOPT_RETURNTRANSFER => TRUE,
                CURLOPT_TIMEOUT => 10,
                CURLOPT_POSTFIELDS => array(
                    'chat_id' => 371289480,
                    'text' => $message['body'],
                ),
            )
        );
        curl_exec($ch);*/
    }


}
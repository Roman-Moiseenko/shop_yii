<?php


namespace shop\services;


use shop\entities\shop\order\Order;
use shop\entities\shop\order\Status;
use shop\entities\user\User;
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
  //  private $supportEmail;
 //   private $adminEmail;

    public function __construct(/*$supportEmail, $adminEmail, */MailerInterface $mailer)
    {
        $this->mailer = $mailer;
       // $this->supportEmail = $supportEmail;
       // $this->adminEmail = $adminEmail;
    }

    public function contact(ContactForm $form): void
    {
        if (!$email = ParamsHelper::get('emailContact')) {
            throw new \DomainException('Не найден почтовый адрес администратора');
            //$email  = $this->adminEmail;
        }
        $send = $this->mailer->compose()
            ->setTo($email)
            ->setFrom([\Yii::$app->params['supportEmail'] => 'Обращение клиента'])
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
        $body = 'Заказ № ' . $order->id . '.  На сумму ' . $order->cost . "\n" .
            'Текущий статус ' . OrderHelper::statusName($order->current_status) . "\n"  .
            ' Покупатель ' . ($order->user)->fullname->getFullname() . "\n"  .
            ' Телефон ' . ($order->user)->phone;
        $message = [
            'subject' => 'Заказ ' . OrderHelper::statusName($order->current_status), 'body' => $body];
        if (ParamsHelper::get('sendEmail') == 1) $this->sendEMAILNoticeOrder($message);
        if (ParamsHelper::get('sendPhone') == 1) $this->sendSMSNoticeOrder($message);
        if (ParamsHelper::get('sendTelegram') == 1) $this->sendTELEGRAMNoticeOrder($message);

        $this->sendNoticeUser($order);

    }

    private function sendEMAILNoticeOrder(array $message)
    {
        if (!$email = ParamsHelper::get('emailOrder')) {
            throw new \DomainException('Не найден почтовый адрес администратора');
            //$email  = $this->adminEmail;
        }

        $send = $this->mailer->compose()
            ->setTo($email)
            ->setFrom([\Yii::$app->params['supportEmail'] => 'Уведомление с сайта'])
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
        $phone = ParamsHelper::get('phoneOrder');
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

    private function sendNoticeUser(Order $order)
    {
      /*  $message = '';
        if ($order->current_status == Status::COMPLETED) {
            $message = 'Ваш заказ № ' . $order->id . ' Был завершен';
        }*/
        /** @var User $user */
        //$user = $order->getUser();
        $send = $this->mailer->compose()
            ->setTo($order->user->email)
            ->setFrom([\Yii::$app->params['supportEmail'] => 'kupi41.ru'])
            //->setReplyTo()
            ->setSubject('Изменения по Вашему заказу')
            ->setTextBody('Новый статус ' . OrderHelper::statusName($order->current_status))
            ->send();
        if (!$send) {
            throw new \RuntimeException('Ошибка отправки');
        }
        //TODO отправка сообщения клиенту о статусе его заказа (email и SMS)   ДОДЕЛАТЬ!!!!!!!!!!!
        // сделать красивое сообщение html
        // СМС после переноса сайта на купи41
    }


}
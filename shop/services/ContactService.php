<?php

namespace shop\services;

use shop\entities\shop\order\Order;
use shop\entities\shop\order\Status;
use shop\forms\ContactForm;
use shop\helpers\OrderHelper;
use shop\helpers\ParamsHelper;
use yii\mail\MailerInterface;

class ContactService
{

    /**
     * @var MailerInterface
     */
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function contact(ContactForm $form): void
    {
        if (!$email = ParamsHelper::get('emailContact')) {
            throw new \DomainException('Не найден почтовый адрес администратора');
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
        //Уведомления в магазин
        if (ParamsHelper::get('sendEmail') == 1) $this->sendEMAILNoticeOrder($order);
        if (ParamsHelper::get('sendPhone') == 1) $this->sendSMSNoticeOrder($order);
        if (ParamsHelper::get('sendTelegram') == 1) $this->sendTELEGRAMNoticeOrder($order);
        //Отправка клиенту
        $this->sendNoticeUser($order);
    }

    private function sendEMAILNoticeOrder(Order $order)
    {
        if (!$email = ParamsHelper::get('emailOrder')) {
            throw new \DomainException('Не найден почтовый адрес администратора');
        }

        $send = $this->mailer->compose('noticeAdmin', ['order' => $order])
            ->setTo($email)
            ->setFrom([\Yii::$app->params['supportEmail'] => 'Уведомление с сайта'])
            ->setSubject('Заказ ' . OrderHelper::statusName($order->current_status))
            ->send();
        if (!$send) {
            throw new \RuntimeException('Ошибка отправки');
        }
    }

    private function sendSMSNoticeOrder(Order $order)
    {
        if (\Yii::$app->params['notSendSMS']) return;
        if ($order->current_status == Status::PAID) {
            $result = \Yii::$app->sms->send('7' . ParamsHelper::get('phoneOrder'), 'Заказ №' .
                $order->id . ' ' . OrderHelper::statusName($order->current_status));
            if (!$result)
                throw new \DomainException('Ошибка отправки СМС-сообщения');
        }
    }

    private function sendTELEGRAMNoticeOrder(Order $order)
    {
//TODO Сделать отправку  Telegram
   \Yii::$app->telegram->sendMessage([
            'chat_id' => 371289480,
            'text' => '',
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
        if (!empty($order->user->email)) {
            $send = $this->mailer->compose('noticeClient', ['order' => $order])
                ->setTo($order->user->email)
                ->setFrom([\Yii::$app->params['supportEmail'] => 'kupi41.ru'])
                ->setSubject('Информация по Вашему заказу')
                ->send();
            if (!$send) {
                throw new \RuntimeException('Ошибка отправки');
            }
        }
        if (\Yii::$app->params['notSendSMS']) return;
        if (!empty($phone = $order->user->phone)) {
            /** СОБРАН */
            if ($order->current_status == Status::SENT) {
                $result = \Yii::$app->sms->send('7' . $phone, 'kupi41.ru. Ваш заказ №' .
                    $order->id . ' собран');
                if (!$result)
                    throw new \DomainException('Ошибка отправки СМС-сообщения');
            }
            /** ОТМЕНЕН */
            if ($order->current_status == Status::CANCELLED) {
                $result = \Yii::$app->sms->send('7' . $phone, 'kupi41.ru. Ваш заказ №' .
                    $order->id . ' отменен. ' . $order->cancel_reason);
                if (!$result)
                    throw new \DomainException('Ошибка отправки СМС-сообщения');
            }
            /** ОПЛАЧЕН */
            if ($order->current_status == Status::PAID) {
                $result = \Yii::$app->sms->send('7' . $phone, 'kupi41.ru. Ваш заказ №' .
                    $order->id . ' оплачен. Дождитесь сборки заказа.');
                if (!$result)
                    throw new \DomainException('Ошибка отправки СМС-сообщения');
            }
        }
    }
}
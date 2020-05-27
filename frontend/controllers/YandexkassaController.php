<?php


namespace frontend\controllers;


use shop\entities\user\User;
use shop\readModels\shop\OrderReadRepository;
use shop\services\shop\OrderService;
use YandexCheckout\Client;
use YandexCheckout\Common\Exceptions\ApiException;
use YandexCheckout\Common\Exceptions\BadApiRequestException;
use YandexCheckout\Common\Exceptions\ForbiddenException;
use YandexCheckout\Common\Exceptions\InternalServerError;
use YandexCheckout\Common\Exceptions\NotFoundException;
use YandexCheckout\Common\Exceptions\ResponseProcessingException;
use YandexCheckout\Common\Exceptions\TooManyRequestsException;
use YandexCheckout\Common\Exceptions\UnauthorizedException;
use YandexCheckout\Model\PaymentInterface;
use yii\web\Controller;

class YandexkassaController extends Controller
{

    public $enableCsrfValidation = false;
    //const TEST_PAY = true;
    /**
     * @var OrderReadRepository
     */
    private $orders;
    /**
     * @var OrderService
     */
    private $service;
    /**
     * @var Client
     */
    private $client;
    private $yandexkassa = [];

    public function __construct($id, $module,
                                OrderReadRepository $orders,
                                OrderService $service,
                                Client $client,
                                $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->orders = $orders;
        $this->service = $service;

        $this->client = $client;
        $this->yandexkassa = \Yii::$app->params['yandexkassa'];
        $this->client->setAuth($this->yandexkassa['login'], $this->yandexkassa['password']);
    }

    public function actionPayorder($id)
    {
        $user = User::findOne(\Yii::$app->user->id);
        $order = $this->orders->findOwn($user->id, $id);

        $items = [];
        foreach ($order->items as $orderItem) {
            $product = $orderItem->getProduct();
            $items[] = array('description' => addslashes($product->name),
                'quantity' => $orderItem->quantity,
                'amount' => array('value' => $orderItem->price, 'currency' => 'RUB'),
                'vat_code' => 1);
        }
        $this->yandexkassa['confirmation']['return_url'] .= $order->id;
        /** -> */
        // TODO Заглушка для dev-режима
        if (YII_DEBUG) return $this->redirect(['/yandexkassa/responce', 'id' => $order->id]);
        /** <- */
        try {
            $payment = $this->client->createPayment(
                [
                    'amount' => [
                        'value' => $order->cost,
                        'currency' => 'RUB',
                    ],
                    'payment_method_data' => $this->yandexkassa['payment_method_data'],
                    'receipt' => array(
                        'email' => $user->email,
                        'items' => $items,
                    ),
                    'confirmation' => $this->yandexkassa['confirmation'],
                    'capture' => true,
                    'description' => 'Заказ № ' . $order->id,
                ],
                uniqid('', true)
            );
        } catch (BadApiRequestException $e) {
        } catch (ForbiddenException $e) {
        } catch (InternalServerError $e) {
        } catch (NotFoundException $e) {
        } catch (ResponseProcessingException $e) {
        } catch (TooManyRequestsException $e) {
        } catch (UnauthorizedException $e) {
        } catch (ApiException $e) {
            \Yii::$app->errorHandler->logException($e);
            \Yii::$app->session->setFlash('error', $e->getMessage());
            return $this->redirect(['/cabinet/order/view', 'id' => $id]);
        }
        $_SESSION['paymentid'] = $payment->id;
    }

    public function actionResponce($id)
    {
        /** -> */
        if (YII_DEBUG) {  // TODO Заглушка для dev-режима
            $this->succeeded($id, null);
            return;
        };
        /** <-  */
        try {
            $payment = $this->client->getPaymentInfo($_SESSION['paymentid']);
            unset($_SESSION['paymentid']);
            $this->{$payment->status}($id, $payment);
            /**  succeeded, canceled, waiting_for_capture, pending */
        } catch (\Throwable $e) {
            \Yii::$app->errorHandler->logException($e);
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['/cabinet/order/view', 'id' => $id]);
    }

    private function canceled($id, PaymentInterface $payment = null)
    {
        \Yii::$app->session->setFlash(
            'error',
            'Платеж не прошел! Попробуйте позже. ' .
                   'Отмена ' .  $payment->getCancellationDetails()->getParty() . '. ' .
                   'По причине ' .  $payment->getCancellationDetails()->getReason() . '.'
        );
        if (YII_DEBUG) return $this->redirect(['/cabinet/order/view', 'id' => $id]);
    }

    private function waiting_for_capture($id, PaymentInterface $payment = null)
    {
        //TODO Двух стадийная оплата! Надо или нет?
        \Yii::$app->session->setFlash('info',
            'Платеж ждет подтверждения!' .
            'Как только магазин подтвердит наличие товара, платеж будет списан.' .
            'Дождись завершения операции, не оплачивайте повторно!');
        if (YII_DEBUG) return $this->redirect(['/cabinet/order/view', 'id' => $id]);
    }

    private function pending($id, PaymentInterface $payment = null)
    {
        /*
        \Yii::$app->session->setFlash('error',
            'Платеж не прошел! Какая-то хрень. Попробуйте стандартный способ оплаты по карте.');
        if (!YII_ENV_TEST) return $this->redirect(['/cabinet/order/view', 'id' => $id]); */
        return $this->redirect([$payment->getConfirmation()->getConfirmationUrl()]);
    }

    private function succeeded($id, PaymentInterface $payment = null)
    {
        $user = User::findOne(\Yii::$app->user->id);
        //$order = $this->orders->findOwn($user->id, $id);

        if (!YII_DEBUG) { /** <-- */
            $payment_method = $payment->payment_method->getType();
            $payment_amount = $payment->amount->getValue();
            /**   -> */
        } else {
            $payment_method = 'bank-card';          // TODO Заглушка для dev-режима
            $payment_amount = '000-000' . ' руб.';
        }
        /** <- */

        try {

            $this->service->pay($id, $payment_method);
            \Yii::$app->session->setFlash('success',
                'Платеж успешно оплачен. Сумма платежа составила ' . $payment_amount);
        } catch (\DomainException $e) {
            \Yii::$app->errorHandler->logException($e);
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }
        if (YII_DEBUG) return $this->redirect(['/cabinet/order/view', 'id' => $id]);
    }
}
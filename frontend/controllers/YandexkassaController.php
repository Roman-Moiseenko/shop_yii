<?php


namespace frontend\controllers;


use shop\entities\user\User;
use shop\readModels\shop\OrderReadRepository;
use shop\services\shop\OrderService;
use YandexCheckout\Client;
use YandexCheckout\Common\Exceptions\ApiException;
use YandexCheckout\Common\Exceptions\BadApiRequestException;
use YandexCheckout\Common\Exceptions\ExtensionNotFoundException;
use YandexCheckout\Common\Exceptions\ForbiddenException;
use YandexCheckout\Common\Exceptions\InternalServerError;
use YandexCheckout\Common\Exceptions\NotFoundException;
use YandexCheckout\Common\Exceptions\ResponseProcessingException;
use YandexCheckout\Common\Exceptions\TooManyRequestsException;
use YandexCheckout\Common\Exceptions\UnauthorizedException;
use YandexCheckout\Model\PaymentInterface;
use YandexCheckout\Request\Payments\PaymentResponse;
use yii\web\Controller;

class YandexkassaController extends Controller
{
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
        // TODO Заглушка для dev-режима
        if (!YII_ENV_TEST) return $this->redirect(['/yandexkassa/responce', 'id' => $order->id]);

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
            $_SESSION['paymentid'] = $payment->id;
        } catch (\DomainException $e) {
            \Yii::$app->errorHandler->logException($e);
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }
    }

    public function actionResponce($id)
    {
        if (!YII_ENV_TEST) {  // TODO Заглушка для dev-режима
            $this->success($id, null);
            return;
        };
        try {
            $payment = $this->client->getPaymentInfo($_SESSION['paymentid']);
        } catch (BadApiRequestException $e) {
        } catch (ForbiddenException $e) {
        } catch (InternalServerError $e) {
        } catch (NotFoundException $e) {
        } catch (ResponseProcessingException $e) {
        } catch (TooManyRequestsException $e) {
        } catch (UnauthorizedException $e) {
        } catch (ApiException $e) {
        } catch (ExtensionNotFoundException $e) {
            \Yii::$app->errorHandler->logException($e);
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }

        if ($payment->status === 'succeeded') {
            $this->success($id, $payment);
        } else //TODO добавить по разным ответом от яндекс кассы
        {
            $this->fail($id, $payment);
        }
    }

    private function fail($id, PaymentInterface $payment)
    {
        //TODO добавить ошибку из $payment
        \Yii::$app->session->setFlash('error', 'Платеж не прошел! Попробуйте позже.');
        return $this->redirect(['/cabinet/order/view', 'id' => $id]);
    }

    private function success($id, PaymentInterface $payment = null)
    {
        if (YII_ENV_TEST) {
            $payment_method = $payment->payment_method->getType();
        } else {
            $payment_method = 'bank-card';          // TODO Заглушка для dev-режима
        }

        $user = User::findOne(\Yii::$app->user->id);
        $order = $this->orders->findOwn($user->id, $id);
        try {
            $order->pay($payment_method);
            $order->save(); // ????

            \Yii::$app->session->setFlash('success', 'Платеж успешно оплачен. ');
        } catch (\DomainException $e) {
            \Yii::$app->errorHandler->logException($e);
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }
        // Меняем статус
        // Сообщаем об оплате


        return $this->redirect(['/cabinet/order/view', 'id' => $id]);
    }
}
<?php


namespace frontend\controllers;


use shop\entities\user\User;
use shop\readModels\shop\OrderReadRepository;
use shop\services\shop\OrderService;
use YandexCheckout\Client;
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

        //При дебаге заглушка
        if (!YII_ENV_TEST) return $this->redirect(['/yandexkassa/success', 'id' => $order->id]);

            $this->yandexkassa['confirmation']['return_url'] .= $order->id;
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

    public function actionSuccess($id)
    {
        $succeeded = false;
        $payment_method = 'bank-card';
        if (YII_ENV_TEST) {
            $payment = $this->client->getPaymentInfo($_SESSION['paymentid']);
            if ($payment->status === 'succeeded') {
                $succeeded = true;
                $payment_method = $payment->payment_method->getType();
            }
        } else {
            $succeeded = true;
        }

        if (!$succeeded) {
            \Yii::$app->session->setFlash('error', 'Платеж не прошел! Попробуйте позже.');
            return $this->redirect(['/cabinet/order/view', 'id' => $id]);
        }

        //TODO
        $user = User::findOne(\Yii::$app->user->id);
        $order = $this->orders->findOwn($user->id, $id);
        $order->pay($payment_method);
        $order->save(); // ????

        // Меняем статус
        // Сообщаем об оплате

        \Yii::$app->session->setFlash('success', 'Платеж успешно оплачен. ');
        return $this->redirect(['/cabinet/order/view', 'id' => $id]);
    }
}
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

    public function __construct($id, $module, OrderReadRepository $orders, OrderService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->orders = $orders;
        $this->service = $service;
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
/*
        $yandexkassa = \Yii::$app->get('yandexkassa');
        $client = new Client();
        $client->setAuth($yandexkassa['login'], $yandexkassa['password']);
        $payment = $client->createPayment(
           [
                'amount' => [
                    'value' => '$order->total',
                    'currency' => 'RUB',
                ],
                'payment_method_data' => $yandexkassa['payment_method_data'],
                'receipt' => array(
                    'email' => $user->email,
                    'items' => $items,
                ),
                'confirmation' => $yandexkassa['confirmation'],
                'capture' => true,
                'description' => 'Заказ № ' . $order->id,
            ],
            uniqid('', true)
        );
        */
    }

    public function actionSuccess($id)
    {
        //TODO
        // Меняем статус
        // Сообщаем об оплате
    }
}
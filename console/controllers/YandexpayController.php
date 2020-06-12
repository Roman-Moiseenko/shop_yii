<?php


namespace console\controllers;


use GuzzleHttp\Handler\StreamHandler;
use shop\entities\shop\order\Order;
use shop\entities\shop\order\Status;
use shop\readModels\shop\OrderReadRepository;
use shop\services\shop\OrderService;
use YandexCheckout\Client;
use yii\console\Controller;

class YandexpayController extends Controller
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
    }

    public function actionCheck()
    {
        $orders = Order::find()->andWhere(['current_status' => Status::NEW])->andWhere(['<>', 'payment_id', ''])->all();
        if (count($orders) == 0){ echo 'Нет заказов требующих подтверждения'; return;}
        $yandexkassa = \Yii::$app->params['yandexkassa'];
        $this->client->setAuth($yandexkassa['login'], $yandexkassa['password']);

        foreach ($orders as $order) {
            echo 'payment_id = ' . $order->payment_id;
            $payment = $this->client->getPaymentInfo($order->payment_id);

            if ($payment->status == 'succeeded') {
                $this->service->pay($order->id, $payment->payment_method->getType());
            }
            if ($payment->status == 'canceled') {
                $this->service->cancel($order->id, 'Платеж отменен банком');
            }

            /**  succeeded, canceled, waiting_for_capture, pending */
        }

    }
}
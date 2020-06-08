<?php


namespace console\controllers;


use shop\entities\shop\order\Order;
use shop\entities\shop\order\Status;
use shop\readModels\shop\OrderReadRepository;
use shop\repositories\shop\OrderRepository;
use shop\services\shop\OrderService;
use yii\console\Controller;

class ClearorderController extends Controller
{
    /**
     * @var OrderService
     */
    private $service;

    public function __construct($id, $module, OrderService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }

    public function actionClear()
    {
        //Загрузка всех контроллеров со статусом new
        echo 'Начало очистки заказов' . "\n";
        $orders = Order::find()
            ->andWhere(['current_status' => Status::NEW])
            ->andWhere(['<', 'created_at', time() + 3 * 3600 * 24])
            ->all();
        echo 'Кол-во просроченных заказов' . count($orders) . "\n";
        foreach ($orders as $order) {
            $this->service->remove($order->id);
            echo 'Заказ №' . $order->id . ' удален.' . "\n";
        }
    }
}
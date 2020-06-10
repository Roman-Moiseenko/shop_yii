<?php


namespace backend\widgets;


use shop\entities\shop\order\Order;
use shop\entities\shop\order\Status;
use yii\base\Widget;

class OrderHeaderWidget extends Widget
{
    public function __construct($config = [])
    {
        parent::__construct($config);
    }

    public function run()
    {
        $orders = Order::find()->andWhere(['IN', 'current_status', [Status::NEW, Status::PAID]])->all();
        return $this->render('orders', ['orders' => $orders]);
    }
}
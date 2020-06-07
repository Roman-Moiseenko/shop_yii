<?php


namespace shop\repositories\shop;


use shop\entities\shop\order\Order;
use shop\repositories\NotFoundException;

class OrderRepository
{
    public function get($id): Order
    {
        if (!$order = Order::findOne($id)) {
            throw new NotFoundException('Заказ не найден.');
        }
        return $order;
    }

    public function save(Order $order): void
    {
        if (!$order->save()) {
            throw new \RuntimeException('Ошибка сохранения Заказа.');
        }
    }

    public function remove(Order $order): void
    {
        if (!$order->delete()) {
            throw new \RuntimeException('Ошибка удаления Заказа.');
        }
    }
}
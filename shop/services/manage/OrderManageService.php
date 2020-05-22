<?php


namespace shop\services\manage;


use shop\entities\shop\DeliveryMethod;
use shop\repositories\shop\DeliveryMethodRepository;
use shop\repositories\shop\OrderRepository;

class OrderManageService
{

    //Todo Доделать класс
    private $orders;
    private $deliveryMethods;

    public function __construct(OrderRepository $orders, DeliveryMethodRepository $deliveryMethods)
    {
        $this->orders = $orders;
        $this->deliveryMethods = $deliveryMethods;
    }

    public function setStatus($status): void
    {

    }

    public function remove($id): void
    {
        $order = $this->orders->get($id);
        $this->orders->remove($order);
    }

    public function delItem($id, $itemId): void
    {

    }

    public function setDelivery($id, DeliveryMethod $delivery)
    {

    }
}
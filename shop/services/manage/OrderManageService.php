<?php


namespace shop\services\manage;


use shop\forms\shop\order\SetStatusOrderForm;
use shop\repositories\shop\DeliveryMethodRepository;
use shop\repositories\shop\OrderRepository;

class OrderManageService
{

    private $orders;
    private $deliveryMethods;

    public function __construct(OrderRepository $orders, DeliveryMethodRepository $deliveryMethods)
    {
        $this->orders = $orders;
        $this->deliveryMethods = $deliveryMethods;
    }

    public function remove($id): void
    {
        $order = $this->orders->get($id);
        $this->orders->remove($order);
    }

    public function setStatusForm($id, SetStatusOrderForm $form)
    {
        $order = $this->orders->get($id);
        $order->addStatus($form->current_status);
        if (!empty($form->cancel_reason)) $order->cancel_reason = $form->cancel_reason;
        $this->orders->save($order);
    }
}
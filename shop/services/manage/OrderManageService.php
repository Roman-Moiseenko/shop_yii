<?php


namespace shop\services\manage;


use shop\entities\shop\order\Status;
use shop\forms\shop\order\SetStatusOrderForm;
use shop\repositories\shop\DeliveryMethodRepository;
use shop\repositories\shop\OrderRepository;
use shop\services\shop\OrderService;

class OrderManageService
{

    private $orders;
    private $deliveryMethods;
    /**
     * @var OrderService
     */
    private $service;

    public function __construct(OrderRepository $orders, DeliveryMethodRepository $deliveryMethods, OrderService $service)
    {
        $this->orders = $orders;
        $this->deliveryMethods = $deliveryMethods;
        $this->service = $service;
    }

    public function remove($id): void
    {
        $order = $this->orders->get($id);
        $this->orders->remove($order);
    }

    public function setStatusForm($id, SetStatusOrderForm $form)
    {
        //$order = $this->orders->get($id);
        switch ($form->current_status) {
            case Status::PAID:
                $this->service->pay($id,'Admin_pay'); break;
            case Status::SENT:
                $this->service->send($id); break;
            case Status::COMPLETED:
                $this->service->complete($id); break;
            case Status::CANCELLED:
                $this->service->cancel($id, $form->cancel_reason); break;
            case Status::CANCELLED_BY_CUSTOMER:
                $this->service->cancel($id,'Отменен пользователем'); break;
            case Status::WAIT:
                $this->service->wait($id); break;
            default:
                    throw new \DomainException('Неизвестный статус заказа');
        }
       /* $order->addStatus($form->current_status);
        if (!empty($form->cancel_reason)) $order->cancel_reason = $form->cancel_reason;*/
    }
}
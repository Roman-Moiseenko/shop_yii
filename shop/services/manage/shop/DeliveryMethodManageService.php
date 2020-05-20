<?php


namespace shop\services\manage\shop;


use shop\entities\shop\DeliveryMethod;
use shop\forms\manage\shop\DeliveryMethodForm;
use shop\repositories\shop\DeliveryMethodRepository;

class DeliveryMethodManageService
{
    /**
     * @var DeliveryMethodRepository
     */
    private $service;

    public function __construct(DeliveryMethodRepository $service)
    {
        $this->service = $service;
    }

    public function create(DeliveryMethodForm $form): DeliveryMethod
    {
        $delivery = DeliveryMethod::create(
            $form->name,
            $form->cost,
            $form->amount_cart_min
        );

        $this->service->save($delivery);
        return $delivery;
    }

    public function edit($id, DeliveryMethodForm $form): void
    {
        $delivery = $this->service->get($id);
        $delivery->edit(
            $form->name,
            $form->cost,
            $form->amount_cart_min
        );
        $this->service->save($delivery);
    }

    public function remove($id): void
    {
        $delivery = $this->service->get($id);
        $this->service->remove($delivery);
    }
}
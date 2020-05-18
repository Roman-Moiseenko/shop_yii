<?php


namespace shop\services\shop;


use shop\entities\shop\discount\Discount;
use shop\forms\shop\DiscountForm;
use shop\repositories\shop\DiscountRepository;

class DiscountService
{

    /**
     * @var DiscountRepository
     */
    private $discounts;

    public function __construct(DiscountRepository $discounts)
    {
        $this->discounts = $discounts;
    }

    public function create(DiscountForm $form): Discount
    {
        $discount = Discount::create(
            $form->name,
            $form->percent,
            $form->active,
            $form->_from,
            $form->_to,
            $form->type_class
        );

        $this->discounts->save($discount);
        return $discount;
    }
    public function edit($id, DiscountForm $form): void
    {
        $discount = $this->discounts->get($id);
        $discount->edit(
            $form->name,
            $form->percent,
            $form->active,
            $form->_from,
            $form->_to,
            $form->type_class
        );

        $this->discounts->save($discount);

    }

    public function remove($id): void
    {
        $discount = $this->discounts->get($id);
        $this->discounts->remove($discount);
    }

    public function activate($id, bool $param)
    {
        $discount = $this->discounts->get($id);
        if ($param) {
            $discount->activate();
        } else {
            $discount->draft();
        }
        $this->discounts->save($discount);
    }
}
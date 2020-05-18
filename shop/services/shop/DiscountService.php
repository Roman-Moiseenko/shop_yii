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

        );

        $this->discounts->save($discount);

    }
    public function edit($id, DiscountForm $form): void
    {
        $discount = $this->discounts->get($id);
        $discount->edit(

        );

        $this->discounts->save($discount);
    }

    public function remove($id): void
    {
        $discount = $this->discounts->get($id);
        $this->discounts->remove($discount);
    }
}
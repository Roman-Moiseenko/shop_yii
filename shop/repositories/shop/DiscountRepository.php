<?php


namespace shop\repositories\shop;


use shop\entities\shop\discount\Discount;
use shop\repositories\NotFoundException;

class DiscountRepository
{
    public function get($id): Discount
    {
        if (!$discount = Discount::findOne($id)) {
            throw new NotFoundException('Скидка не найдена ' . $id);
        }
        return $discount;
    }

    public function save(Discount $discount):void
    {
        if (!$discount->save()) {
            throw new \RuntimeException('Скидка не сохранена');
        }
    }

    public function remove(Discount $discount):void
    {
        if (!$discount->delete()) {
            throw new \RuntimeException('Скидка не удалена');
        }
    }
}
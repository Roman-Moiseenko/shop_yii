<?php


namespace shop\entities\shop\discount;


use shop\cart\cost\Cost;
use shop\entities\shop\discount\Discount;

class CostEnableDiscount extends EnabledDiscountInterface
{

    public static function isEnabled(Discount $discount, Cost $cost = null): bool
    {
        if ((int)$discount->_from <= $cost->getOrigin() && $cost->getOrigin() <= (int)$discount->_to) return true;
        return false;
    }

    public static function getName(): string
    {
        return 'По сумме покупок';
    }

    public static function getCaption(string $from_to): string
    {
        return $from_to . ' &#8381;';
    }
}
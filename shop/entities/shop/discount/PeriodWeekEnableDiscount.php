<?php


namespace shop\entities\shop\discount;


use shop\cart\cost\Cost;
use shop\entities\shop\discount\Discount;

class PeriodWeekEnableDiscount extends EnabledDiscountInterface
{

    public static function isEnabled(Discount $discount, Cost $cost = null): bool
    {
        $now_w = date('w');
        if ((int)$discount->_from <= $now_w && $now_w <= (int)$discount->_to) return true;
        return false;
    }
}
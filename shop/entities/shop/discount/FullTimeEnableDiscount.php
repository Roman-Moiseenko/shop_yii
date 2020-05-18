<?php


namespace shop\entities\shop\discount;


use shop\cart\cost\Cost;
use shop\entities\shop\discount\Discount;

class FullTimeEnableDiscount extends EnabledDiscountInterface
{

    public static function isEnabled(Discount $discount, Cost $cost = null): bool
    {
        $now = time();
        $from = strtotime($discount->_from . ' 00:00:00');
        $to = strtotime($discount->_to . '23:59:59');
        if ($from <= $now && $now <= $to) return true;
        return false;
    }
    public static function getName(): string
    {
        return  ' По точному периоду';
    }

    public static function getCaption(string $from_to): string
    {
        $date = date($from_to . ' 00:00:00');
        return date('d F Y', $date);
    }

}
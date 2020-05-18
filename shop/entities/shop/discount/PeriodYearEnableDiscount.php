<?php


namespace shop\entities\shop\discount;


use shop\cart\cost\Cost;
use shop\entities\shop\discount\Discount;

class PeriodYearEnableDiscount extends EnabledDiscountInterface
{

    public static function isEnabled(Discount $discount, Cost $cost = null): bool
    {
        $now = time();
        $now_y = date('Y');
        $from = strtotime($now_y . '-' . $discount->_from . ' 00:00:00');
        $to = strtotime($now_y . '-' . $discount->_to . '23:59:59');
        if ($from <= $now && $now <= $to) return true;
        return false;
    }
    public static function getName(): string
    {
        return  ' По периоду текущего года';
    }
    public static function getCaption(string $from_to): string
    {
        $now_y = date('Y');
        $date = date($now_y . '-' . $from_to . ' 00:00:00');
        return date('d F Y', $date);
    }
}
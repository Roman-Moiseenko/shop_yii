<?php


namespace shop\entities\shop\discount;

use shop\cart\cost\Cost;
use shop\helpers\MonthHelper;

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
        return 'По точному периоду';
    }

    public static function getCaption(string $from_to): string
    {
        preg_match('/([0-9]{1,2})-([0-9]{1,2})-([0-9]{2,4})/is', $from_to, $math);
        $day = $math[1];
        $month = (int)$math[2];
        $year = $math[3];
        if (strlen($year) == 2) $year = '20' . $year;
        return $day . ' ' . MonthHelper::month($month) . ' ' . $year . ' г';
    }

}
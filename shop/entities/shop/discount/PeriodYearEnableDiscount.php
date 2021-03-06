<?php


namespace shop\entities\shop\discount;

use shop\cart\cost\Cost;
use shop\helpers\MonthHelper;

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
        return 'По периоду текущего года';
    }

    public static function getCaption(string $from_to): string
    {
        preg_match('/([0-9]{1,2})-([0-9]{1,2})/is', $from_to, $math);
        $day = $math[1];
        $month = (int)$math[2];
        return $day . ' ' . MonthHelper::month($month);
    }

}
<?php


namespace shop\entities\shop\discount;


use shop\cart\cost\Cost;
use shop\entities\shop\discount\Discount;

class PeriodMonthEnableDiscount extends EnabledDiscountInterface
{

    public static function isEnabled(Discount $discount, Cost $cost = null): bool
    {
        $now = time();
        $now_y = date('Y');
        $now_m = date('m');
        $from = strtotime($now_y . '-' . $now_m . '-' . $discount->_from . ' 00:00:00');
        $to = strtotime($now_y . '-' . $now_m . '-' . $discount->_to . '23:59:59');
        if ($from <= $now && $now <= $to) return true;
        return false;
    }

    public static function getName(): string
    {
        return  'По числам месяца';
    }
    public static function getCaption(string $from_to): string
    {
        try {
            preg_match('/([0-9]{1,2})/is', $from_to, $math);
            $day = (int)$math[1];
            return $day;
        } catch (\DomainException $e) {
            
        }

    }
}
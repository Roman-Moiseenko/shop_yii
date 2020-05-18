<?php


namespace shop\entities\shop\discount;


use shop\cart\cost\Cost;
use shop\entities\shop\discount\Discount;

abstract class EnabledDiscountInterface
{
    abstract public static function isEnabled (Discount $discount, Cost $cost = null): bool;

    public function getType()
    {
        return static::class;
    }

    abstract public static function getName(): string;
    abstract public static function getCaption(string $from_to): string ;
}
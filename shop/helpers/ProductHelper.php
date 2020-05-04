<?php


namespace shop\helpers;


use shop\entities\shop\product\Product;

class ProductHelper
{
    public static function UnitsList(): array
    {
        return ['м', 'шт', 'кг', 'упак', 'бухта'];
    }

    public static function remains(Product $product)
    {
        return $product->remains . ' ' . $product->units;
    }
}
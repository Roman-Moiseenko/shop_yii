<?php


namespace shop\helpers;


use phpDocumentor\Reflection\Types\Integer;
use shop\entities\shop\product\Product;
use shop\readModels\shop\ReviewReadRepository;

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

    public static function countReviews(Product $product)
    {
        $reviews = new ReviewReadRepository();
        return count($reviews->getByProduct($product->id));
    }
}
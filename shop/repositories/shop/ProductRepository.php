<?php


namespace shop\repositories\shop;


use shop\entities\shop\product\Product;
use shop\repositories\NotFoundException;

class ProductRepository
{
    public function get($id): Product
    {
        if (!$product = Product::findOne($id)) {
            throw new NotFoundException('Продукт не найден');
        }
        return $product;
    }

    public function getBy1C($code1C): Product
    {
        if (!$product = Product::find()->andWhere(['code1C' => $code1C])) {
            throw new NotFoundException('Продукт не найден');
        }
        return $product;
    }

    public function save(Product $product): void
    {
        if (!$product->save()) {
            throw new \RuntimeException('Продукт не сохранен');
        }
    }

    public function remove(Product $product)
    {
        if (!$product->delete()) {
            throw new \RuntimeException('Ошибка удаления Продукта');
        }
    }
    public function existsBy1C($code1C)
    {
        return Product::find()->andWhere(['code1C' => $code1C])->exists();
    }
    public function existsByBrand($id)
    {
        return Product::find()->andWhere(['brand_id' => $id])->exists();
    }
    public function existsByMainCategory($id)
    {
        return Product::find()->andWhere(['category_id' => $id])->exists();
    }
}
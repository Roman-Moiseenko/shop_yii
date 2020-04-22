<?php


namespace shop\repositories\shop;


use shop\entities\shop\Brand;
use shop\repositories\NotFoundException;

class BrandRepository
{
    public function get($id): Brand
    {
        if (!$brand = Brand::findOne($id)) {
            throw new NotFoundException('Бренд не найден');
        }
        return $brand;
    }

    public function save(Brand $brand): void
    {
        if (!$brand->save()) {
            throw new \RuntimeException('Бренд не сохранен');
        }
    }

    public function remove(Brand $brand)
    {
        if (!$brand->delete()) {
            throw new \RuntimeException('Ошибка удаления бренда');
        }
    }
}
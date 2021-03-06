<?php


namespace shop\repositories\shop;


use shop\entities\shop\DeliveryMethod;
use shop\repositories\NotFoundException;

class DeliveryMethodRepository
{

    public function get($id): DeliveryMethod
    {
        if (!$method = DeliveryMethod::findOne($id)) {
            throw new NotFoundException('Доставка не найдена.');
        }
        return $method;
    }

    public function findByName($name): ?DeliveryMethod
    {
        return DeliveryMethod::findOne(['name' => $name]);
    }

    public function save(DeliveryMethod $method): void
    {
        if (!$method->save()) {
            throw new \RuntimeException('Ошибка сохранения доставки.');
        }
    }

    public function remove(DeliveryMethod $method): void
    {
        if (!$method->delete()) {
            throw new \RuntimeException('Ошибка удаления доставки.');
        }
    }
}
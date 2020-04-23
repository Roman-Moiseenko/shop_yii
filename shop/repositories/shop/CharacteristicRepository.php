<?php


namespace shop\repositories\shop;


use shop\entities\shop\Characteristic;
use shop\repositories\NotFoundException;

class CharacteristicRepository
{

    public function get($id): Characteristic
    {
        if (!$characteristic = Characteristic::findOne($id)) {
            throw new NotFoundException('Характеристика не найдена');
        }
        return $characteristic;
    }

    public function save(Characteristic $characteristic): void
    {
        if (!$characteristic->save()) {
            throw new \RuntimeException('Ошибка сохранения');
        }
    }

    public function remove(Characteristic $characteristic): void
    {
        if (!$characteristic->delete()) {
            throw new \RuntimeException('Ошибка удаления');
        }
    }
}
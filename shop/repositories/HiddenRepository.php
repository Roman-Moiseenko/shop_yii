<?php


namespace shop\repositories;


use shop\entities\shop\Hidden;

class HiddenRepository
{
    public function get($id): Hidden
    {
        if (!$code1C = Hidden::findOne($id)) {
            throw new NotFoundException('Удаленый код 1С не найден');
        }
        return $code1C;
    }

    public function save(Hidden $code1C): void
    {
        if (!$code1C->save()) {
            throw new \RuntimeException('Удаленый код 1С не сохранен');
        }
    }
    public function remove(Hidden $code1C): void
    {
        if (!$code1C->delete()) {
            throw new \RuntimeException('Ошибка удаления Удаленый код 1С');
        }
    }
    public function isFind($code1C): bool
    {
       return (Hidden::findOne(['code1C' => $code1C])) ? true : false;
    }
}
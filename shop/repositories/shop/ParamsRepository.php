<?php


namespace shop\repositories\shop;


use shop\entities\Params;
use shop\repositories\NotFoundException;

class ParamsRepository
{
    public function get($key): Params
    {
        if (!$params = Params::findOne($key)) {
            throw new NotFoundException('Параметр не найден ' . $key);
        }
        return $params;
    }

    public function find($key): ?Params
    {
        if (!$params = Params::findOne($key)) {
            return null;
        }
        return $params;
    }

    public function save(Params $params): void
    {
        if (!$params->save()) {
            throw new \RuntimeException('Параметр не сохранен');
        }
    }

    public function remove(Params $params): void
    {
        if (!$params->delete()) {
            throw new \RuntimeException('Ошибка удаления параметра');
        }
    }

    public function all(): array
    {
        return Params::find()->all();
    }

}
<?php


namespace shop\repositories;


use shop\entities\shop\RegAttribute;

class RegAttributeRepository
{
    public function get($id): RegAttribute
    {
        if (!$reg = RegAttribute::findOne($id)) {
            throw new NotFoundException('Регулярка не найдена' . $id);
        }
        return $reg;
    }

    public function save(RegAttribute $reg): void
    {
        if (!$reg->save()) {
            throw new \RuntimeException('Регулярка не сохранена');
        }
    }

    public function remove(RegAttribute $reg)
    {
        if (!$reg->delete()) {
            throw new \RuntimeException('Ошибка удаления регулярки');
        }
    }
}
<?php


namespace shop\repositories\shop;


use shop\entities\shop\Tag;
use shop\repositories\NotFoundException;

class TagRepository
{
    public function get($id): Tag
    {
        if (!$tag = Tag::findOne($id)) {
            throw new NotFoundException('Метка не найдена');
        }
        return $tag;
    }

    public function save(Tag $tag): void
    {
        if (!$tag->save()) {
            throw new \RuntimeException('Метка не сохранена');
        }
    }
    public function remove(Tag $tag): void
    {
        if (!$tag->delete()) {
            throw new \RuntimeException('Ошибка удаления метки');
        }
    }
    public function findByName($name): ?Tag
    {
        return Tag::findOne(['name' => $name]);
    }

}
<?php


namespace shop\repositories;


use shop\entities\shop\Page;

class PageRepository
{
    public function get($id): Page
    {
        if (!$page = Page::findOne($id)) {
            throw new NotFoundException('Страница не найдена.');
        }
        return $page;
    }

    public function save(Page $page): void
    {
        if (!$page->save()) {
            throw new \RuntimeException('Ошибка сохранения Страницы.');
        }
    }
    public function remove(Page $page): void
    {
        if (!$page->delete()) {
            throw new \RuntimeException('Ошибка удаления Страницы.');
        }
    }
}
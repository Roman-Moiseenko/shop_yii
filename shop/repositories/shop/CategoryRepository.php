<?php


namespace shop\repositories\shop;


use shop\entities\shop\Category;
use shop\repositories\NotFoundException;
use yii\caching\TagDependency;

class CategoryRepository
{

    public function get($id): Category
    {
        if (!$category = Category::findOne($id)) {
            throw new NotFoundException('Категория не найдена');
        }
        return $category;
    }

    public function save(Category $category): void
    {
        if (!$category->save()) {
            throw new \RuntimeException('Saving error.');
        }
        TagDependency::invalidate(\Yii::$app->cache, ['category']);
       // $this->dispatcher->dispatch(new EntityPersisted($category));
    }

    public function remove(Category $category): void
    {
        if (!$category->delete()) {
            throw new \RuntimeException('Removing error.');
        }
        TagDependency::invalidate(\Yii::$app->cache, ['category']);
        //$this->dispatcher->dispatch(new EntityRemoved($category));
    }


}
<?php


namespace shop\readModels\shop;


use shop\entities\shop\Brand;

class BrandReadRepository
{
    public function find($id): ?Brand
    {
        return Brand::findOne($id);
    }
    public function getAll(): array
    {
        return Brand::find()->andWhere(['<>', 'id', 1])->all();
    }
    public function getLimit($limit): array
    {
        $all = Brand::find()->andWhere(['<>', 'id', 1])->all();
        $items =  array_rand($all, $limit);
        $result = [];
        foreach ($items as $item) {
            $result[] = $all[$item];
        }
        return $result;
    }
}
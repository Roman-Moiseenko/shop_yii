<?php


namespace shop\readModels\shop;


use shop\entities\shop\Brand;

class BrandReadRepository
{
    public function find($id): ?Brand
    {
        return Brand::findOne($id);
    }
    public function getAll()
    {
        return Brand::find()->andWhere(['<>', 'id', 1])->all();
    }
}
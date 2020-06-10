<?php


namespace shop\readModels\shop;


use shop\entities\Shop\Product\Review;

class ReviewReadRepository
{

    public function getByProduct($id): array
    {
        return Review::find()->andWhere(['product_id' => $id])->orderBy(['created_at' => SORT_DESC])->all();
    }
}
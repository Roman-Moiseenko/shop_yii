<?php


namespace shop\readModels\shop;

use shop\entities\shop\product\Review;

class ReviewReadRepository
{

    public function getByProduct($id): array
    {
        return Review::find()
            ->andWhere(['product_id' => $id])
            ->andWhere(['active' => true])
            ->orderBy(['created_at' => SORT_DESC])->all();
    }
}
<?php


namespace backend\widgets;


use shop\entities\shop\product\Review;
use yii\base\Widget;

class ReviewHeaderWidget extends Widget
{
    public function run()
    {
        $reviews = Review::find()->andWhere(['active' => false])->all();
        return $this->render('reviews', ['reviews' => $reviews]);
    }
}
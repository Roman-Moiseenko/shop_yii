<?php


namespace shop\repositories\shop;


use shop\entities\shop\product\Review;
use shop\repositories\NotFoundException;

class ReviewRepository
{

    public function get($id): Review
    {
        if (!$review = Review::findOne($id)) {
            throw new NotFoundException('Отзыв не найден');
        }
        return $review;
    }

    public function save(Review $review): void
    {
        if (!$review->save()) {
            throw new \RuntimeException('Отзыв не сохранен');
        }
    }

    public function remove(Review $review)
    {
        if (!$review->delete()) {
            throw new \RuntimeException('Ошибка удаления Отзыва');
        }
    }
}
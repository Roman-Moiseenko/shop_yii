<?php


namespace frontend\widgets;


use shop\readModels\shop\ReviewReadRepository;
use yii\base\Widget;

class ReviewsWidget extends Widget
{
    public $product;
    /**
     * @var ReviewReadRepository
     */
    private $reviews;

    public function __construct(ReviewReadRepository $reviews, $config = [])
    {
        parent::__construct($config);
        $this->reviews = $reviews;
    }
    public function run()
    {
        $reviews = $this->reviews->getByProduct($this->product->id);
        return $this->render('review', [
            'reviews' => $reviews,
        ]);
    }
}
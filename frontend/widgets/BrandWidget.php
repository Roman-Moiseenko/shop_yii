<?php

namespace frontend\widgets;

use shop\readModels\shop\BrandReadRepository;
use yii\base\Widget;

class BrandWidget extends Widget
{
    public $limit;
    /**
     * @var BrandReadRepository
     */
    private $repository;

    public function __construct(BrandReadRepository $repository, $config = [])
    {
        parent::__construct($config);
        $this->repository = $repository;
    }

    public function run()
    {
        return $this->render('brand', ['brands' => $this->repository->getLimit($this->limit)]);
    }

}
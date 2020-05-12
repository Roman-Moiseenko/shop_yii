<?php


namespace frontend\widgets;


use shop\forms\shop\search\SearchForm;
use shop\readModels\shop\BrandReadRepository;
use shop\readModels\shop\CategoryReadRepository;
use yii\base\Widget;

class SearchWidget extends Widget
{

    public $category;
    /**
     * @var CategoryReadRepository
     */
    private $categories;
    /**
     * @var BrandReadRepository
     */
    private $brands;

    public function __construct(CategoryReadRepository $categories, BrandReadRepository $brands, $config = [])
    {
        parent::__construct($config);
        $this->categories = $categories;
        $this->brands = $brands;
    }

    public function run()
    {

        $form = new SearchForm();
        $form->category = $this->category;
        $form->setAttribute($this->category);

        return $this->render('search', [
            'searchForm' => $form,
        ]);
    }
}
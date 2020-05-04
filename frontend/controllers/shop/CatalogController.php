<?php


namespace frontend\controllers\shop;


use shop\entities\shop\product\Product;
use shop\forms\shop\AddToCartForm;
use shop\readModels\shop\BrandReadRepository;
use shop\readModels\shop\CategoryReadRepository;
use shop\readModels\shop\ProductReadRepository;
use shop\readModels\shop\TagReadRepository;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class CatalogController extends Controller
{
    public $layout = 'catalog';
    /**
     * @var ProductReadRepository
     */
    private $products;
    /**
     * @var CategoryReadRepository
     */
    private $categories;
    /**
     * @var BrandReadRepository
     */
    private $brands;
    /**
     * @var TagReadRepository
     */
    private $tags;

    public function __construct(
        $id,
        $module,
        ProductReadRepository $products,
        CategoryReadRepository $categories,
        BrandReadRepository $brands,
        TagReadRepository $tags,
        $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->products = $products;
        $this->categories = $categories;
        $this->brands = $brands;
        $this->tags = $tags;
    }

    public function actionIndex()
    {
        $dataProvider = $this->products->getAll();
        $category = $this->categories->getRoot();
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'category' => $category,
            ]);
    }

    public function actionCategory($id)
    {
        if (!$category = $this->categories->find($id)) {
            throw new NotFoundHttpException('Категория не найдена');
        }
        $dataProvider = $this->products->getAllByCategory($category);
        return $this->render('category', [
            'dataProvider' => $dataProvider,
            'category' => $category,
        ]);
    }
    public function actionBrand($id)
    {
        if (!$brand = $this->brands->find($id)) {
            throw new NotFoundHttpException('Бренд не найден');
        }
        $dataProvider = $this->products->getAllByBrand($brand);
        return $this->render('brand', [
            'dataProvider' => $dataProvider,
            'brand' => $brand,
        ]);
    }

    public function actionTag($id)
    {
        if (!$tag = $this->tags->find($id)) {
            throw new NotFoundHttpException('Метка не найдена');
        }
        $dataProvider = $this->products->getAllByTag($tag);
        return $this->render('tag', [
            'dataProvider' => $dataProvider,
            'tag' => $tag,
        ]);
    }

    public function actionProduct($id)
    {
        $this->layout = '_blank';
        if (!$product = $this->products->find($id)) {
            throw new NotFoundHttpException('Товар не найден');
        }
        $addToCartForm = new AddToCartForm($product);
        return $this->render('product', [
            'product' => $product,
            'addToCartForm' => $addToCartForm,
        ]);
    }
}
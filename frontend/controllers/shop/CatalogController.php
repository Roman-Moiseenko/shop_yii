<?php


namespace frontend\controllers\shop;


use shop\entities\shop\Category;
use shop\entities\shop\Characteristic;
use shop\entities\shop\product\Product;
use shop\entities\Shop\Product\Value;
use shop\forms\shop\AddToCartForm;
use shop\forms\shop\ReviewForm;
use shop\forms\shop\search\SearchForm;
use shop\readModels\shop\BrandReadRepository;
use shop\readModels\shop\CategoryReadRepository;
use shop\readModels\shop\ProductReadRepository;
use shop\readModels\shop\TagReadRepository;
use shop\services\manage\shop\ProductManageService;
use Yii;
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
    /**
     * @var ProductManageService
     */
    private $service;

    public function __construct(
        $id,
        $module,
        ProductManageService $service,
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
        $this->service = $service;
    }

    public function actionIndex()
    {
        $category = $this->categories->getRoot();
        $search = Yii::$app->request->queryParams['search'] ?? '';
        if ($search != '') {
            $form = new SearchForm();
            $form->text = $search;
            $dataProvider = $this->products->search($form);
        } else {
            $dataProvider = $this->products->getAll();
        }
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

        if ($category->depth < 2) {
            return $this->render('category', [
                'dataProvider' => $dataProvider,
                'category' => $category,
            ]);
        } else {
            $this->layout = 'catalog_filter';
            $form = new SearchForm();
            $form->category = $id;
            $form->setAttribute($id);
            $form->load(\Yii::$app->request->queryParams);
            $form->validate();
            $dataProvider = $this->products->search($form);
            return $this->render('category_filter', [
                'dataProvider' => $dataProvider,
                'category' => $category,
                'searchForm' => $form,
            ]);
        }
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
        $this->layout = 'blank';
        if (!$product = $this->products->find($id)) {
            throw new NotFoundHttpException('Товар не найден');
        }
        // $addToCartForm = new AddToCartForm($product);
        $reviewForm = new ReviewForm();
        /*    if ($addToCartForm->load(Yii::$app->request->post()) && $addToCartForm->validate()) {
            }*/
        if ($reviewForm->load(Yii::$app->request->post()) && $reviewForm->validate()) {
            try {
                $this->service->addReview($id, \Yii::$app->user->id, $reviewForm->vote, $reviewForm->text);
                $this->redirect(['shop/catalog/product', 'id' => $id]);
            } catch (\DomainException $e) {
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('product', [
            'product' => $product,
            //   'addToCartForm' => $addToCartForm,
            'reviewForm' => $reviewForm,
        ]);
    }

    public function actionSearch()
    {
        $form = new SearchForm();

        if (isset(\Yii::$app->request->queryParams['category'])) {
            $id = \Yii::$app->request->queryParams['category'];
            $form->category = $id;
            $form->setAttribute($id);
        }

        $form->load(\Yii::$app->request->queryParams);
        $form->validate();
        $dataProvider = $this->products->search($form);

        return $this->render('search', [
            'dataProvider' => $dataProvider,
            'searchForm' => $form,
        ]);
    }

    public function actionGetsearch()
    {
        $this->layout = '_blank';
        if (\Yii::$app->request->isAjax) {
            $form = new SearchForm();
            $form->text = \Yii::$app->request->bodyParams['text'];
            $form->brand = \Yii::$app->request->bodyParams['brand'];
            if (isset(\Yii::$app->request->bodyParams['id'])) {
                $id = \Yii::$app->request->bodyParams['id'];
                $form->category = $id;
                $form->setAttribute($id);
            }
            return $this->render('_search', [
                'searchForm' => $form,
            ]);
        }
    }
}
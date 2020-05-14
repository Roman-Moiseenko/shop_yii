<?php


namespace frontend\controllers\shop;


use shop\forms\shop\AddToCartForm;
use shop\readModels\shop\ProductReadRepository;
use shop\repositories\NotFoundException;
use shop\services\shop\CartService;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class CartController extends Controller
{

    public $layout = 'blank';
    /**
     * @var CartService
     */
    private $service;
    /**
     * @var ProductReadRepository
     */
    private $products;

    public function __construct($id, $module, CartService $service, ProductReadRepository $products, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
        $this->products = $products;
    }

    public function behaviors()
    {
        return [
            'verb' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'quantity' => ['POST'],
                    'remove' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $cart = $this->service->getCart();

        return $this->render('index', [
            'cart' => $cart,
        ]);
    }

    public function actionAdd($id)
    {
        if (!$product = $this->products->find($id)) {
            throw new NotFoundHttpException('Товар не найден');
        }

        try {
            $this->service->add($product->id, 1);
            \Yii::$app->session->setFlash('success', 'Добавлен в корзину!');
            return $this->redirect(\Yii::$app->request->referrer);
        } catch (\DomainException $e) {
            \Yii::$app->errorHandler->logException($e);
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }
    }
}
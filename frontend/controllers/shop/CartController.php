<?php

namespace frontend\controllers\shop;

use shop\readModels\shop\ProductReadRepository;
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
        $quantity = \Yii::$app->request->post('quantity');
        if (empty($quantity)) $quantity = 1; //TODO При 0 => empty !!!!
        if ($quantity < 1) {
            \Yii::$app->session->setFlash('error', 'Кол-во товара должно быть больше 0 !');
            return $this->redirect(\Yii::$app->request->referrer);
        }
        try {
            $this->service->add($product->id, $quantity);
            \Yii::$app->session->setFlash('success', 'Добавлен в корзину!');
            return $this->redirect(\Yii::$app->request->referrer);
        } catch (\DomainException $e) {
            \Yii::$app->errorHandler->logException($e);
            \Yii::$app->session->setFlash('error', $e->getMessage());
            return $this->redirect(\Yii::$app->request->referrer);
        }
    }

    public function actionQuantity($id)
    {
        try {
            $this->service->set($id, (int)\Yii::$app->request->post('quantity'));
        } catch (\DomainException $e) {
            \Yii::$app->errorHandler->logException($e);
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['index']);
    }
    public function actionRemove($id)
    {
        try {
            $this->service->remove($id);
        } catch (\DomainException $e) {
            \Yii::$app->errorHandler->logException($e);
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(\Yii::$app->request->referrer);
        //return $this->redirect(['index']);
    }

}
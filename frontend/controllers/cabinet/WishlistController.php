<?php


namespace frontend\controllers\cabinet;


use shop\readModels\shop\ProductReadRepository;
use shop\services\cabinet\WishlistService;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class WishlistController extends Controller
{
    public $layout = 'cabinet';
    /**
     * @var WishlistService
     */
    private $service;
    /**
     * @var ProductReadRepository
     */
    private $products;

    public function __construct($id, $module, WishlistService $service, ProductReadRepository $products, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
        $this->products = $products;
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' =>['index', 'add', 'delete'],
                'rules' => [
                    'index' => [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    'add' => [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    'delete' => [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'add' => ['POST'],
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $dataProvider = $this->products->getWishlist(\Yii::$app->user->id);

        return $this->render('index', [
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionAdd($id)
    {
        try {
            $this->service->add(\Yii::$app->user->id, $id);
            \Yii::$app->session->setFlash('success', 'Добавлено в избранное.');
        } catch (\DomainException $e) {
            \Yii::$app->errorHandler->logException($e);
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(\Yii::$app->request->referrer ?: ['index']);
    }

    public function actionDelete($id)
    {
        try {
            $this->service->remove(\Yii::$app->user->id, $id);
        } catch (\DomainException $e) {
            \Yii::$app->errorHandler->logException($e);
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['index']);
    }
}
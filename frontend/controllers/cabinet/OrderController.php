<?php

namespace frontend\controllers\cabinet;


use shop\readModels\shop\OrderReadRepository;
use shop\services\shop\OrderService;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class OrderController extends Controller
{
    public $layout = 'cabinet';
    private $orders;
    /**
     * @var OrderService
     */
    private $service;

    public function __construct($id, $module, OrderReadRepository $orders, OrderService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->orders = $orders;
        $this->service = $service;
    }

    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = $this->orders->getOwm(\Yii::$app->user->id);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        if (!$order = $this->orders->findOwn(\Yii::$app->user->id, $id)) {
            throw new NotFoundHttpException('Заказ не найден!');
        }

        return $this->render('view', [
            'order' => $order,
        ]);
    }

    public function actionUpdate($id)
    {
        //TODO Сделать страницу редактирования заказа
        // изменения доставки, контактных данных
        // удаление позиций с заказа .... !?
    }

    public function actionDelete($id)
    {
        if (!$order = $this->orders->findOwn(\Yii::$app->user->id, $id)) {
            throw new NotFoundHttpException('Заказ не найден!');
        }

        try {
            $this->service->remove($order->id);

        } catch (\DomainException $e) {
            \Yii::$app->errorHandler->logException($e);
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }
        $this->redirect(['/cabinet/order/index']);
    }
}
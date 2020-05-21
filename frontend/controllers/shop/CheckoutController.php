<?php


namespace frontend\controllers\shop;


use shop\cart\Cart;
use shop\forms\shop\order\OrderForm;
use shop\services\shop\OrderService;
use yii\filters\AccessControl;
use yii\web\Controller;

class CheckoutController extends Controller
{
    public $layout = 'blank';
    /**
     * @var OrderService
     */
    private $service;
    /**
     * @var Cart
     */
    private $cart;

    public function __construct($id, $module, OrderService $service, Cart $cart, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
        $this->cart = $cart;
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['index'],
                'rules' => [
                    'index' => [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ]
        ];
    }

    public function actionIndex()
    {
        $form = new OrderForm($this->cart->getCost()->getTotal());

        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $order = $this->service->checkout(\Yii::$app->user->id, $form);
                return $this->redirect(['/cabinet/order/view', 'id' => $order->id]);
            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e);
            }
        }
        return $this->render('index', [
            'cart' => $this->cart,
            'model' => $form,
        ]);

    }
}
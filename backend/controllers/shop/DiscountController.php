<?php

namespace backend\controllers\shop;

use shop\forms\shop\DiscountForm;
use shop\services\shop\DiscountService;
use Yii;
use shop\entities\shop\discount\Discount;
use backend\forms\Shop\DiscountSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DiscountController implements the CRUD actions for Discount model.
 */
class DiscountController extends Controller
{

    /**
     * @var DiscountService
     */
    private $service;

    public function __construct($id, $module, DiscountService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Discount models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DiscountSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Discount model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Discount model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $form = new DiscountForm();

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $discount = $this->service->create($form);
                return $this->redirect(['view', 'id' => $discount->id]);
            } catch (\DomainException $e)
            {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('create', [
            'model' => $form,
        ]);
    }

    /**
     * Updates an existing Discount model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $discount = $this->findModel($id);
        $form = new DiscountForm($discount);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->edit($id, $form);
                return $this->redirect(['view', 'id' => $discount->id]);
        } catch (\DomainException $e)
            {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update', [
            'model' => $form,
            'discount' => $discount,
        ]);
    }

    /**
     * Deletes an existing Discount model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->service->remove($id);
        return $this->redirect(['index']);
    }

    /**
     * Finds the Discount model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Discount the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id): Discount
    {
        if (($model = Discount::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionActivate($id)
    {
        if (\Yii::$app->request->isAjax) {
            $activate = \Yii::$app->request->bodyParams['activate'];
            $this->service->activate($id, ($activate == 1) ? false : true);
        }
    }
}

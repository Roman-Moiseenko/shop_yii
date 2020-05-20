<?php

namespace backend\controllers\shop;

use shop\forms\manage\shop\DeliveryMethodForm;
use shop\services\manage\shop\DeliveryMethodManageService;
use Yii;
use shop\entities\shop\DeliveryMethod;
use backend\forms\shop\DeliveryMethodSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DeliveryMethodController implements the CRUD actions for DeliveryMethod model.
 */
class DeliveryMethodController extends Controller
{
    /**
     * @var DeliveryMethodManageService
     */
    private $service;

    /**
     * {@inheritdoc}
     */

    public function __construct($id, $module, DeliveryMethodManageService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }

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
     * Lists all DeliveryMethod models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DeliveryMethodSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single DeliveryMethod model.
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
     * Creates a new DeliveryMethod model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $form = new DeliveryMethodForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $delivery = $this->service->create($form);
                return $this->redirect(['view', 'id' => $delivery->id]);
            } catch (\DomainException $e)
            {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e);
            }

        }
        return $this->render('create', [
            'model' => $form,
        ]);
    }

    /**
     * Updates an existing DeliveryMethod model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {

        $delivery = $this->findModel($id);

        $form = new DeliveryMethodForm($delivery);

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->edit($id, $form);
                return $this->redirect(['view', 'id' => $delivery->id]);
            } catch (\DomainException $e)
            {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e);
            }
        }

        return $this->render('update', [
            'model' => $form,
            'delivery' => $delivery,
        ]);
    }

    /**
     * Deletes an existing DeliveryMethod model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        /* @var DeliveryMethod $delivery*/
        $delivery = $this->findModel($id);
        $this->service->remove($delivery->id);
        return $this->redirect(['index']);
    }

    /**
     * Finds the DeliveryMethod model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return DeliveryMethod the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DeliveryMethod::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

<?php

namespace backend\controllers\data;

use shop\forms\data\RegAttributeForm;
use shop\services\manage\RegAttributeManageService;
use Yii;
use shop\entities\shop\RegAttribute;
use backend\forms\data\RegAttributeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * RegAttributeController implements the CRUD actions for RegAttribute model.
 */
class RegAttributeController extends Controller
{

    /**
     * @var RegAttributeManageService
     */
    private $service;

    public function __construct($id, $module, RegAttributeManageService $service, $config = [])
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
     * Lists all RegAttribute models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RegAttributeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single RegAttribute model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $reg = $this->findModel($id);
        return $this->render('view', [
            'model' => $this->findModel($id),
            'reg' => $reg,
        ]);
    }

    /**
     * Creates a new RegAttribute model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $form = new RegAttributeForm();

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $reg = $this->service->create($form);
                return $this->redirect(['view', 'id' => $reg->id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }

        }
        return $this->render('create', [
            'model' => $form,
        ]);
    }
    public function actionCopy($id)
    {
        $reg = $this->findModel($id);
        $form = new RegAttributeForm($reg);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $reg = $this->service->create($form);
                return $this->redirect(['view', 'id' => $reg->id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('create', [
            'model' => $form,
          //  'reg' => $reg,
        ]);
    }
    /**
     * Updates an existing RegAttribute model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $reg = $this->findModel($id);
        $form = new RegAttributeForm($reg);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->edit($id, $form);
                return $this->redirect(['view', 'id' => $reg->id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('update', [
            'model' => $form,
            'reg' => $reg,
        ]);
    }

    /**
     * Deletes an existing RegAttribute model.
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
     * Finds the RegAttribute model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return RegAttribute the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = RegAttribute::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

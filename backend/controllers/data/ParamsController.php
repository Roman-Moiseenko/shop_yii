<?php

namespace backend\controllers\data;

use shop\entities\user\Rbac;
use shop\forms\data\ParamsForm;
use shop\services\manage\ParamsManageService;
use Yii;
use shop\entities\Params;
use backend\forms\data\ParamsSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ParamsController implements the CRUD actions for Params model.
 */
class ParamsController extends Controller
{

    /**
     * @var ParamsManageService
     */
    private $service;

    public function __construct($id, $module, ParamsManageService $service, $config = [])
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
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => [Rbac::ROLE_ADMIN],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Params models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ParamsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Params model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'params' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Params model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $form = new ParamsForm();

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $params = $this->service->create($form);
                return $this->redirect(['view', 'id' => $form->key]);
            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e);
            }
        }
        return $this->render('create', [
            'model' => $form,
        ]);
    }

    /**
     * Updates an existing Params model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {

        $params = $this->findModel($id);
        $form = new ParamsForm($params);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->edit($form);
                return $this->redirect(['view', 'id' => $params->key]);
            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e);
            }
        }

        return $this->render('update', [
            'model' => $form,
            'params' => $params,
        ]);
    }

    /**
     * Deletes an existing Params model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        //$params = $this->findModel($id);
        $this->service->remove($id);
        return $this->redirect(['index']);
    }

    /**
     * Finds the Params model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Params the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Params::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

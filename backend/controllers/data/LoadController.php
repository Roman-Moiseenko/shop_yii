<?php


namespace backend\controllers\data;


use shop\entities\user\Rbac;
use shop\forms\data\BrandLoadForm;
use shop\forms\data\FilesForm;
use shop\services\manage\LoaderManageService;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\UploadedFile;

class LoadController extends Controller
{
    public $layout = 'main';
    /**
     * @var LoaderManageService
     */
    private $service;

    public function __construct($id, $module, LoaderManageService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }
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
        ];
    }
    public function actionCatalog()
    {
        //Загружаем форму && $form->validate()
        $form = new FilesForm();

        if (Yii::$app->request->isPost) {
            try {
                $form->file_catalog = UploadedFile::getInstance($form, 'file_catalog');
                $file = $form->upload();
                $path = dirname(__DIR__, 3) . '/static/data/';
                $this->service->loadCategory($path, $file);
            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('catalog', [
            'model' => $form,
            'title' => 'Загрузить каталоги',
        ]);
    }

    public function actionProducts()
    {
        $form = new FilesForm();
        if (Yii::$app->request->isPost) {
            try {
                $form->file_catalog = UploadedFile::getInstance($form, 'file_catalog');
                $file = $form->upload();
                $path = dirname(__DIR__, 3) . '/static/data/';
                $this->service->loadProducts($path, $file);
            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('catalog', [
            'model' => $form,
            'title' => 'Загрузить товары',
        ]);
    }

    public function actionBrands($category = null, $brand = null)
    {
        $form = new BrandLoadForm();

        if (Yii::$app->request->isPost) {
            try {

                if (isset(\Yii::$app->request->bodyParams['BrandLoadForm'])) {
                    $category = \Yii::$app->request->bodyParams['BrandLoadForm']['category'];
                    $brand = \Yii::$app->request->bodyParams['BrandLoadForm']['brand'];
                    $this->service->setBrand($category, $brand);
                } else {
                    $this->service->updateBrand();
                }
            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('brands', [
            'model' => $form
        ]);
    }



    public function actionAttributes()
    {
        if (Yii::$app->request->isPost) {
            try {
                $this->service->updateAttributes();
            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('attributes', [

        ]);
    }

}
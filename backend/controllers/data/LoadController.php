<?php


namespace backend\controllers\data;


use shop\entities\shop\Hidden;
use shop\forms\data\FilesForm;

use shop\repositories\HiddenRepository;
use shop\services\manage\LoaderManageService;
use Yii;
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

    public function actionCatalog()
    {
        //Загружаем форму && $form->validate()
        $form = new FilesForm();

        if (Yii::$app->request->isPost) {
            try {
                $form->file_catalog = UploadedFile::getInstance($form, 'file_catalog');
                $file = $form->upload();
                $this->service->loadCategory($file);
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
                $this->service->loadProducts($file);
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

    public function actionBrands()
    {
        if (Yii::$app->request->isPost) {
            try {
                $this->service->updateBrand();
            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('brands', [

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
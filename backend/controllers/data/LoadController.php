<?php


namespace backend\controllers\data;


use shop\forms\data\FilesForm;
use shop\services\manage\shop\CategoryManageService;
use Yii;
use yii\web\Controller;
use yii\web\UploadedFile;

class LoadController extends Controller
{
    public $layout = 'main';
    /**
     * @var CategoryManageService
     */
    private $service;

    public function __construct($id, $module, CategoryManageService $service, $config = [])
{
    parent::__construct($id, $module, $config);
    $this->service = $service;
}

    public function actionCatalog()
    {
        //Загружаем форму && $form->validate()
        $form = new FilesForm();

        if (Yii::$app->request->isPost) {
            $form->file_catalog = UploadedFile::getInstance($form, 'file_catalog');
            $file = $form->upload();
            $this->service->loadFromFile($file);

        }
     /*   if ($form->load(Yii::$app->request->post()) ) {
            try {
                $form->upload();
                var_dump($form->file_catalog); exit();

               // $this->service->addPhotos($product->id, $photosForm);
                //return $this->redirect(['view', 'id' => $product->id]);
            } catch (\DomainException $e) {
               // Yii::$app->errorHandler->logException($e);
                //Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }*/
        //Получаем файл
        //Запускаем сервис(файл)
        //рендер

        return $this->render('catalog', [
            'model' => $form,
        ]);
    }
}
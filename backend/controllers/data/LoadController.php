<?php


namespace backend\controllers\data;


use shop\forms\data\FilesForm;
use Yii;
use yii\web\Controller;

class LoadController extends Controller
{
    public $layout = 'main';

    public function actionCatalog()
    {
        //Загружаем форму
        $form = new FilesForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {

                var_dump($form->files); exit();

               // $this->service->addPhotos($product->id, $photosForm);
                //return $this->redirect(['view', 'id' => $product->id]);
            } catch (\DomainException $e) {
               // Yii::$app->errorHandler->logException($e);
                //Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        //Получаем файл
        //Запускаем сервис(файл)
        //рендер

        return $this->render('catalog', [
            'model' => $form,
        ]);
    }
}
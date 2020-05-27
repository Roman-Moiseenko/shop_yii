<?php


namespace frontend\controllers;


use shop\forms\ContactForm;
use shop\services\ContactService;
use Yii;
use yii\web\Controller;

class ContactController extends Controller
{
    public  $layout = 'blank';
    /**
     * @var ContactService
     */
    private  $contact;

    public function __construct($id, $module, ContactService $contact, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->contact = $contact;
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $form = new ContactForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->contactService->contact($form);
                Yii::$app->session->setFlash('success', 'Спасибо за Ваш запрос, мы обязательно решим Вашу проблему и сообщим Вам.');
            } catch (\RuntimeException $e) {
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
            return $this->refresh();
        } else {
            return $this->render('index', [
                'model' => $form,
            ]);
        }
    }
}
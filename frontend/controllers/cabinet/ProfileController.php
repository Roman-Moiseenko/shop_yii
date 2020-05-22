<?php


namespace frontend\controllers\cabinet;


use shop\entities\user\User;
use shop\forms\manage\user\ContactDataForm;
use shop\forms\manage\user\DeliveryProfileForm;
use shop\forms\manage\user\UserEditForm;
use shop\services\manage\UserManageService;
use yii\filters\AccessControl;
use yii\web\Controller;

class ProfileController extends Controller
{

    public $layout = 'cabinet';
    /**
     * @var UserManageService
     */
    private $service;

    public function __construct($id, $module, UserManageService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['edit', 'contact', 'delivery'],
                'rules' => [
                    'edit' => [
                        'actions' => ['edit'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    'contact' => [
                        'actions' => ['contact'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    'delivery' => [
                        'actions' => ['delivery'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionEdit($id)
    {
        $user = $this->findModel($id);
        $form = new UserEditForm($user);

        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->update($id, $form);
                return $this->redirect(['/cabinet/default/index', 'id' => $user->id]);

            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('edit', [
            'model' => $form,
            'user' => $user,
        ]);
    }

    public function actionContact($id)
    {
        $user = $this->findModel($id);
        $form = new ContactDataForm($user);

        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->setContact($id, $form);
                return $this->redirect(['/cabinet/default/index', 'id' => $user->id]);

            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('contact', [
            'model' => $form,
            'user' => $user,
        ]);
    }

    public function actionDelivery($id)
    {
        $user = $this->findModel($id);
        $form = new DeliveryProfileForm($user);

        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->setDelivery($id, $form);
                return $this->redirect(['/cabinet/default/index', 'id' => $user->id]);

            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('delivery', [
            'model' => $form,
            'user' => $user,
        ]);
    }

    private function findModel($id)
    {
        return User::findOne($id);
    }
}
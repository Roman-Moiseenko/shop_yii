<?php


namespace frontend\controllers\cabinet;


use shop\forms\manage\user\UserCreateForm;
use shop\forms\manage\user\UserEditForm;
use shop\repositories\UserRepository;
use shop\services\manage\UserManageService;
use yii\filters\AccessControl;
use yii\web\Controller;

class DefaultController extends Controller
{
    public  $layout = 'cabinet';
    /**
     * @var UserManageService
     */
    private $user;

    public function __construct($id, $module, UserRepository $user, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->user = $user;
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['index'],
                'rules' => [
                        'index' => [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $user = $this->user->get(\Yii::$app->user->id);
        return $this->render('index', [
            'user' => $user,
        ]);
    }
}
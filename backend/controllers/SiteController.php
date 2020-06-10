<?php
namespace backend\controllers;

use shop\entities\user\Rbac;
use shop\entities\user\User;
use shop\forms\auth\LoginForm;
use shop\services\AuthService;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;


/**
 * Site controller
 */
class SiteController extends Controller
{

    public  $layout = 'main';
    /**
     * {@inheritdoc}
     */
    public function __construct($id, $module , $config = [])
    {
        parent::__construct($id, $module, $config);

    }

   /* public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'deny' => true,
                        'roles' => [Rbac::ROLE_USER],
                    ],
                ],
            ],
        ];
    }*/
    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(\Yii::$app->params['baseUrl'] . '/login');
        }
        if (!\Yii::$app->user->can(Rbac::ROLE_TRADER)) {
            //$user = User::findOne(!\Yii::$app->user->id);
            $this->layout = 'main-deny';
            return $this->render('error', [
                'name' => '', //$user->fullname->getFullname(),
                'message' => 'Нет доступа к данному сайту!',
            ]);
        }
        return $this->render('index');
    }


}

<?php
namespace backend\controllers;

use shop\forms\auth\LoginForm;
use shop\services\AuthService;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;


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
        return $this->render('index');
    }


}

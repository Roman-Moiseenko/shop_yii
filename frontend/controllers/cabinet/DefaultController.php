<?php


namespace frontend\controllers\cabinet;


use yii\filters\AccessControl;
use yii\web\Controller;

class DefaultController extends Controller
{
    public string $layout = 'cabinet';
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
        return $this->render('index');
    }
}
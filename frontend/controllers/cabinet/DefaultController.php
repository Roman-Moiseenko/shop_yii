<?php


namespace frontend\controllers\cabinet;


use yii\web\Controller;

class DefaultController extends Controller
{
    public function behaviors()
    {
        return [
            'class' => AccessControl::className(),
            'rule' => [
                [
                    'allow' => true,
                    'roles' => ['@'],
                ]
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }
}
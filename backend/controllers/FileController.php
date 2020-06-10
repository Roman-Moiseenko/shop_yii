<?php


namespace backend\controllers;


use shop\entities\user\Rbac;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class FileController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => [Rbac::ROLE_MANAGER],
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
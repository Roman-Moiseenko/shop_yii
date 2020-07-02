<?php


namespace api\controllers\user;


use shop\entities\user\User;
use yii\rest\Controller;

class ProfileController extends Controller
{
    public function actionIndex(): User
    {
        return $this->findModel();
    }

    protected function verbs()
    {
        return [
            'index' => ['get'],
        ];
    }

    private function findModel(): User
    {
        return User::findOne(\Yii::$app->user->id);
    }
}
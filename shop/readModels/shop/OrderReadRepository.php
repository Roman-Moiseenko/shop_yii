<?php


namespace shop\readModels\shop;


use shop\entities\shop\order\Order;
use yii\data\ActiveDataProvider;

class OrderReadRepository
{
    public function getOwm($userId): ActiveDataProvider
    {
        return new ActiveDataProvider([
            'query' => Order::find()
                ->andWhere(['user_id' => $userId])
                ->orderBy(['id' => SORT_DESC]),
            'sort' => false,
        ]);
    }

    public function findOwn($userId, $id): ?Order
    {
        return Order::find()->andWhere(['user_id' => $userId, 'id' => $id])->one();
    }
}
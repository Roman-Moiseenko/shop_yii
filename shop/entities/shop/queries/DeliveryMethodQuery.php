<?php


namespace shop\entities\shop\queries;


use yii\db\ActiveQuery;

class DeliveryMethodQuery extends ActiveQuery
{
    public function availableForAmount($amount)
    {
        //TODO Проверить работу
        return $this
            ->andWhere(['>=', 'amount_cart_min', $amount])
            ->andWhere(['<', 'amount_cart_min', function (ActiveQuery $query) use($amount) {
                return $query->andWhere(['<', 'amount_cart_min', $amount])->max('amount_cart_min');
            }]);
    }
}
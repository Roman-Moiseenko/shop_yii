<?php


namespace shop\entities\shop\queries;


use shop\entities\shop\DeliveryMethod;
use yii\db\ActiveQuery;

class DeliveryMethodQuery extends ActiveQuery
{
    public function availableForAmount($amount)
    {
        //TODO Проверить работу
        // ДОРАБОТАТЬ ДОСТАВКУ!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
        $amountMax = DeliveryMethod::find()
            ->select('amount_cart_min')
            ->andWhere(['<', 'amount_cart_min', $amount])
            ->max('amount_cart_min');
        //echo $amountMax; exit();
        return $this
            ->andWhere(['<', 'amount_cart_min', $amount])
            ->andWhere(['>=', 'amount_cart_min', $amountMax])->groupBy(['name', 'amount_cart_min']);
    }
}
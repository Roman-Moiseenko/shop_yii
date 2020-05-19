<?php


namespace shop\entities\shop\product\queries;


use shop\entities\shop\product\Product;
use yii\db\ActiveQuery;

class ProductQuery extends ActiveQuery
{
    public function notEmpty($alias = null)
    {
        return $this->andWhere(['>', ($alias ? $alias . '.' : '') . 'remains', 0]);
    }
    public function active($alias = null)
    {
        return $this->andWhere([($alias ? $alias . '.' : '') . 'status' =>Product::STATUS_ACTIVE]);
    }
}
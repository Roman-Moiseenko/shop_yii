<?php


namespace shop\entities\shop\product\queries;


use yii\db\ActiveQuery;

class ProductQuery extends ActiveQuery
{
    public function NotEmpty($alias = null)
    {
        return $this->andWhere(['>', ($alias ? $alias . '.' : '') . 'remains', 0]);
    }

}
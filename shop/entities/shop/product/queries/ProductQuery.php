<?php


namespace shop\entities\shop\product\queries;


use yii\db\ActiveQuery;

class ProductQuery extends ActiveQuery
{
    public function NotEmpty()
    {
        return $this->andWhere(['>', 'remains', 0]);
    }

}
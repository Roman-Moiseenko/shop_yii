<?php


namespace shop\helpers;



use shop\entities\shop\DeliveryMethod;
use yii\helpers\ArrayHelper;

class DeliveryHelper
{
    public static function list(): array
    {
        return ArrayHelper::map(DeliveryMethod::find()->orderBy('cost')->asArray()->all(),
            'id',
            function (array $delivery) {
                return $delivery['name'];
            }
        );
    }
}
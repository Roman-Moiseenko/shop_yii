<?php


namespace shop\helpers;


use shop\entities\shop\Brand;
use shop\entities\shop\Category;
use shop\entities\shop\Characteristic;
use yii\helpers\ArrayHelper;

class ListHelper
{
    public static function categories(): array
    {
        return ArrayHelper::map(Category::find()->andWhere(['>', 'depth', 0])->
        orderBy('lft')->asArray()->all(),
            'id',
            function (array $category) {
                return ($category['depth'] > 1 ?
                        str_repeat('--', $category['depth'] - 1) . ' ' : '') . $category['name'];
            }
        );
    }

    public static function brands(): array
    {
        return ArrayHelper::map(Brand::find()->orderBy('id')->asArray()->all(),
            'id',
            function (array $brand) {
                return $brand['name'];
            }
        );
    }

    public static function characteristics(): array
    {
        return ArrayHelper::map(Characteristic::find()->orderBy('name')->asArray()->all(),
            'id',
            function (array $characteristic) {
                return $characteristic['name'];
            });
    }

}
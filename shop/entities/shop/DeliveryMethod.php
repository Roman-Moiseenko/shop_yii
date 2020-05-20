<?php


namespace shop\entities\shop;


use shop\entities\shop\queries\DeliveryMethodQuery;
use yii\db\ActiveRecord;

/**
 * Class DeliveryMethod
 * @package shop\entities\shop
 * @property integer $id
 * @property string $name
 * @property integer $cost
 * @property integer $amount_cart_min
 */
class DeliveryMethod extends ActiveRecord
{

    public static function create($name, $cost, $amount_cart_min): self
    {
        $delivery = new static();
        $delivery->name = $name;
        $delivery->cost = $cost;
        $delivery->amount_cart_min = $amount_cart_min;
        return $delivery;
    }

    public function edit($name, $cost, $amount_cart_min): void
    {
        $this->name = $name;
        $this->cost = $cost;
        $this->amount_cart_min = $amount_cart_min;

    }
    public static function tableName()
    {
        return '{{%shop_delivery_methods}}';
    }

    public static function find(): DeliveryMethodQuery
    {
        return new DeliveryMethodQuery(static::class);
    }


}
<?php


namespace shop\entities\shop\order;



use shop\entities\shop\product\Product;
use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property int $order_id
 * @property int $product_id
 * @property string $product_name
 * @property string product_code1C
 * @property int $price
 * @property int $quantity
 */
class OrderItem extends ActiveRecord
{
    public static function create(Product $product, $price, $quantity)
    {
        $item = new static();
        $item->product_id = $product->id;
        $item->product_name = $product->name;
        $item->product_code1C = $product->code1C;
        $item->price = $price;
        $item->quantity = $quantity;
        return $item;
    }

    public function getCost(): int
    {
        return $this->price * $this->quantity;
    }

    public static function tableName(): string
    {
        return '{{%shop_order_items}}';
    }
}
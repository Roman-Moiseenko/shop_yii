<?php


namespace shop\entities\user;


use yii\base\Model;
use yii\db\ActiveRecord;
/**
 * @property integer $user_id
 * @property integer $product_id
 */
class WishlistItem extends ActiveRecord
{


    public static function create($product_id): self
    {
        $wishlist = new static();
        $wishlist->product_id = $product_id;
        return $wishlist;
    }

    public function isForProduct($product_id): bool
    {
        return $this->product_id == $product_id;
    }
    public static function tableName()
    {
        return '{{%user_wishlist_items}}';
    }

}
<?php


namespace shop\entities\shop\product;


use yii\db\ActiveRecord;

/**
 * @property integer $product_id;
 * @property integer $related_id;
 */
class RelatedAssignment extends ActiveRecord
{

    public static function create($relatedId): self
    {
        $related = new static();
        $related->related_id = $relatedId;
        return $related;
    }
    public function isForProduct($id): bool
    {
        return $this->related_id == $id;
    }
    public static function tableName()
    {
        return '{{%shop_related_assignments}}';
    }

}
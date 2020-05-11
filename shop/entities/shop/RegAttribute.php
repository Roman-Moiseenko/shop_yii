<?php


namespace shop\entities\shop;


use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class RegAttribute
 * @package shop\entities\shop
 * @property Category $category
 * @property Characteristic $characteristic;
 * @property integer $category_id
 * @property string $reg_match
 * @property integer $characteristic_id
 */
class RegAttribute  extends ActiveRecord
{

    public static function create($category_id, $reg_match, $characteristic_id): self
    {
        $regattribute = new static();
        $regattribute->category_id = $category_id;
        $regattribute->reg_match = $reg_match;
        $regattribute->characteristic_id = $characteristic_id;
        return $regattribute;
    }

    public function edit($category_id, $reg_match, $characteristic_id): void
    {
        $this->category_id = $category_id;
        $this->reg_match = $reg_match;
        $this->characteristic_id = $characteristic_id;
    }

    public static function tableName()
    {
        return '{{%shop_reg}}';
    }

    public function getCategory(): ActiveQuery
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    public function getCharacteristic(): ActiveQuery
    {
        return $this->hasOne(Characteristic::class, ['id' => 'characteristic_id']);
    }
}
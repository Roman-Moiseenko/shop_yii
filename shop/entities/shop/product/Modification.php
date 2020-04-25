<?php


namespace shop\entities\shop\product;


use yii\db\ActiveRecord;


/**
 * @property integer $id
 * @property string $name
 * @property string $code
 * @property string $price
 */
class Modification extends ActiveRecord
{
    public static function create($code, $name, $price): self
    {
        $modification = new static();
        $modification->code = $code;
        $modification->name = $name;
        $modification->price = $price;
        return $modification;
    }

    public function edit($code, $name, $price): void
    {
        $this->code = $code;
        $this->name = $name;
        $this->price = $price;
    }

    public function isIdEqualTo($id): bool
    {
        return $this->id === $id;
    }

    public static function tableName()
    {
        return '{{%shop_modification}}';
    }

}
<?php


namespace shop\entities\shop;


use yii\db\ActiveRecord;

/**
 * Class Hidden
 * @package shop\entities\shop
 * @property integer $id
 * @property string $code1C
 */

class Hidden extends ActiveRecord
{

    public static function create($code1C): self
    {
        $self = new static();
        $self->code1C = $code1C;
        return $self;
    }

    public static function tableName()
    {
        return '{{%shop_hidden}}';
    }

}
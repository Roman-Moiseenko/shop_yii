<?php


namespace shop\entities;


use yii\db\ActiveRecord;

/**
 * Class Params
 * @package shop\entities
 * @property string $key
 * @property string $value
 * @property string $description
 */

class Params extends ActiveRecord
{

    //public $value;

    public static function create($key, $value, $description): self
    {
        $params = new static();
        $params->key = $key;
        $params->value = $value;
        $params->description = $description;
        return $params;
    }

    public function edit($value, $description)
    {
        $this->value = $value;
        $this->description = $description;
    }

    public static function tableName()
    {
        return '{{%shop_params}}';
    }
}
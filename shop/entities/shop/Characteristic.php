<?php


namespace shop\entities\shop;


use yii\db\ActiveRecord;
use yii\helpers\Json;

/**
 * Class Characteristic
 * @package shop\entities\shop
 * @property integer $id
 * @property string $name
 * @property string $type
 * @property string $required
 * @property string $default
 * @property array $variants
 * @property integer $sort
 */

class Characteristic extends ActiveRecord
{
    const TYPE_STRING = 0;
    const TYPE_INTEGER = 1;
    const TYPE_FLOAT = 2;

    public $variants;

    public static function create($name, $type, $required, $default, array $variants, $sort): self
    {
        $object = new static();
        $object->name = $name;
        $object->type = $type;
        $object->required = $required;
        $object->default = $default;
        if (count($variants) == 1 && $variants[0] == '') {$object->variants = [];}
        else {$object->variants = $variants;}
        $object->sort = $sort;
        return $object;
    }

    public function edit($name, $type, $required, $default, array $variants, $sort): void
    {
        $this->name = $name;
        $this->type = $type;
        $this->required = $required;
        $this->default = $default;
        if (count($variants) == 1 && $variants[0] == '') {$this->variants = [];}
        else {$this->variants = $variants;}
        $this->sort = $sort;
    }

    public function isSelect(): bool
    {
        return count($this->variants) > 0;
    }

    public static function tableName()
    {
        return '{{%shop_characteristics}}';
    }

    public function beforeSave($insert)
    {
        $this->setAttribute('variants_json', Json::encode($this->variants));
        return parent::beforeSave($insert);
    }

    public function afterFind()
    {
        $this->variants = Json::decode($this->getAttribute('variants_json'));
        parent::afterFind();
    }
    public function isString():bool
    {
        return $this->type === self::TYPE_STRING;
    }
    public function isInteger():bool
    {
        return $this->type === self::TYPE_INTEGER;
    }

    public function isFloat():bool
    {
        return $this->type === self::TYPE_FLOAT;
    }

    public function getVariant($var):? string
    {
        foreach ($this->variants as $variant)
        {
            if ($var == $variant) return $variant;

            $var = str_replace(',', '.', $var);
            $variant_point = str_replace(',', '.', $variant);
            if (is_numeric($var) && is_numeric($variant_point) && ((float)$var == (float)$variant_point)) return $variant;

        }
        return null;
    }
}
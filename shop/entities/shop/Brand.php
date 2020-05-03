<?php


namespace shop\entities\shop;

use shop\entities\behaviors\MetaBehavior;
use shop\entities\Meta;
use shop\helpers\SlugHelper;
use yii\db\ActiveRecord;
use yii\helpers\Json;

/**
 * Class Brand
 * @package shop\entities\shop
 * @property integer $id
 * @property string $name
 * @property string $slug
 * @property Meta $meta
 */
class Brand extends ActiveRecord
{
    public $meta;

    public static function create($name, $slug, Meta $meta): self
    {
        $brand = new static();
        $brand->name = $name;
        if (empty($slug)) $slug = SlugHelper::slug($name);
        $brand->slug = $slug;
        $brand->meta = $meta;
        return $brand;
    }

    public function edit($name, $slug, Meta $meta): void
    {
        $this->name = $name;
        if (empty($slug)) $slug = SlugHelper::slug($name);
        $this->slug = $slug;
        $this->meta = $meta;
    }

    public static function tableName()
    {
        return '{{%shop_brands}}';
    }

    public function behaviors()
    {
        return [
            MetaBehavior::class,
        ];
    }
    public function getSeoTile(): string
    {
        return $this->meta->title ?: $this->name;
    }


}
<?php


namespace shop\entities\shop;


use paulzi\nestedsets\NestedSetsBehavior;
use shop\entities\behaviors\MetaBehavior;
use shop\entities\Meta;
use shop\entities\shop\queries\CategoryQuery;
use shop\helpers\SlugHelper;
use yii\db\ActiveRecord;
/**
 * @property integer $id
 * @property string $name
 * @property string $slug
 * @property string $title
 * @property string $description
 * @property integer $lft
 * @property integer $rgt
 * @property integer $depth
 * @property Meta $meta
 * @property string $code1C
 * @property Category $parent
 * @property Category[] $parents
 * @property Category[] $children
 * @property Category $prev
 * @property Category $next
 * @mixin NestedSetsBehavior
 */
class Category extends ActiveRecord
{
    public $meta;

    public static function create($name, $slug, $title, $description, Meta $meta, $code1C = null): self
    {
        $category = new static();
        $category->name = $name;
        if (empty($slug)) $slug = SlugHelper::slug($name);
        $category->slug = $slug;
        $category->title = $title;
        $category->description = $description;
        $category->meta = $meta;

        $category->code1C = $code1C;

        return $category;
    }

    public function edit($name, $slug, $title, $description, Meta $meta, $code1C = null)
    {
        $this->name = $name;
        if (empty($slug)) {
            $slug = SlugHelper::slug($name);
        }
        $this->slug = $slug;
        $this->title = $title;
        $this->description = $description;
        $this->meta = $meta;

        $this->code1C = $code1C;

    }

    public static function tableName()
    {
        return '{{%shop_categories}}';
    }
    public function getSeoTile(): string
    {
        return $this->meta->title ?: $this->getHeadingTile();
    }

    public function getHeadingTile(): string
    {
        return $this->title ?: $this->name;
    }
    public function behaviors()
    {
        return [
            MetaBehavior::class,
            NestedSetsBehavior::class,
        ];
    }
    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL
        ];
    }

    public static function find(): CategoryQuery
    {
        return new CategoryQuery(static::class);
    }

}
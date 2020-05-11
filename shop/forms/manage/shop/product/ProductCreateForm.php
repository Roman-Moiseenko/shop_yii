<?php


namespace shop\forms\manage\shop\product;


use shop\entities\shop\Brand;
use shop\entities\shop\Characteristic;
use shop\entities\shop\product\Product;
use shop\forms\CompositeForm;
use shop\forms\manage\MetaForm;
use yii\helpers\ArrayHelper;

/**
 * @property PriceForm $price
* @property string $code1C
 * @property MetaForm $meta
 * @property CategoriesForm $categories
 * @property PhotosForm $photos
 * @property TagsForm $tags
 * @property ValueForm[] $values
 */
class ProductCreateForm extends CompositeForm
{
    public $brandId;
    public $code;
    public $name;
    public $description;
    public $code1C;
    public $units;
   // public $photos;

    public function __construct($config = [])
    {
        $this->price = new PriceForm();
        $this->meta = new MetaForm();
        $this->categories = new CategoriesForm();
        $this->photos = new PhotosForm();
        $this->tags = new TagsForm();
        $this->values = array_map(function (Characteristic $characteristic) {
            return new ValueForm($characteristic);
        }, Characteristic::find()->orderBy('sort')->all());
        parent::__construct($config);
    }
    public function rules(): array
    {
        return [
            [['brandId', 'name'], 'required'],
            [['code', 'name'], 'string', 'max' => 255],
            [['code1C'], 'string', 'max' => 9],
            [['brandId'], 'integer'],
            [['units'], 'string'],
            [['code'], 'unique', 'targetClass' => Product::class],
            ['description', 'string'],
            ['description', 'string'],
        ];
    }

    public function brandsList(): array
    {
        return ArrayHelper::map(Brand::find()->orderBy('name')->asArray()->all(), 'id', 'name');
    }

    protected function internalForms(): array
    {
        return ['price', 'meta', 'photos', 'categories', 'tags', 'values'];
    }
}
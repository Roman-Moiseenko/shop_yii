<?php


namespace shop\forms\manage\shop;


use shop\entities\Meta;
use shop\entities\shop\Brand;
use shop\forms\manage\MetaForm;
use yii\base\Model;

class BrandForm extends Model
{
    public $name;
    public $slug;
    /** @var Meta $meta */
    public $meta;

    private $_brand;


    public function __construct(Brand $brand, $config = [])
    {
        if ($brand) {
            $this->name = $brand->name;
            $this->slug = $brand->slug;
            $this->meta = new MetaForm($brand->meta);
            $this->_brand = $brand;
        } else {
            $this->meta = new MetaForm();
        }
        parent::__construct($config);
    }
    public function rules(): array
    {
        return [
            [['name', 'slug'], 'required'],
            [['name', 'slug'], 'string', 'max' => 255],
            ['slug', 'match', 'pattern' => '#^[a-z0-9_-]+$#s'],
            [['name', 'slug'], 'unique', 'targetClass' => Brand::class, 'filter' => $this->_brand ? ['<>', 'id', $this->_brand->id] : null]
        ];
    }

    public function load($data, $formName = null)
    {
        return parent::load($data, $formName) and $this->meta->load($data, $formName);
    }

    public function internalForms(): array
    {
        return ['meta'];
    }
}
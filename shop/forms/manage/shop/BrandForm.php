<?php


namespace shop\forms\manage\shop;


use shop\entities\Meta;
use shop\entities\shop\Brand;
use shop\forms\CompositForm;
use shop\forms\manage\MetaForm;
use shop\validators\SlugValidator;
use yii\base\Model;

/**
 * @property MetaForm $meta
 */

class BrandForm extends CompositForm
{
    public $name;
    public $slug;
    /** @var Meta $meta */

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
            ['slug', SlugValidator::class],
            [['name', 'slug'], 'unique', 'targetClass' => Brand::class, 'filter' => $this->_brand ? ['<>', 'id', $this->_brand->id] : null]
        ];
    }


    public function internalForms(): array
    {
        return ['meta'];
    }
}
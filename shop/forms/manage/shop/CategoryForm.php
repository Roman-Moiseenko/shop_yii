<?php


namespace shop\forms\manage\shop;


use shop\entities\shop\Category;
use shop\forms\CompositeForm;
use shop\forms\manage\MetaForm;
use shop\validators\SlugValidator;

class CategoryForm extends CompositeForm
{
    public $name;
    public $slug;
    public $title;
    public $description;
    public $parentid;

    public $code1C;

    private $_category;

    public function __construct(Category $category, $config = [])
    {
        if ($category)
        {
            $this->name = $category->name;
            $this->slug = $category->slug;
            $this->title = $category->title;
            $this->description = $category->description;
            $this->parentid = $category->parent ? $category->parent->id : null;
            $this->meta = new MetaForm($category->meta);
            $this->_category = $category;

            $this->code1C = $category->code1C;
        } else {
            $this->meta = new MetaForm();
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['name', 'slug', 'code1C'], 'required'],
            [['parentId'], 'integer'],
            [['name', 'slug', 'title'], 'string', 'max' => 255],
            ['code1C', 'string', 'max' => 11],
            [['description'], 'string'],
            ['slug', SlugValidator::class],
            //TODO Валидация code1C?????
            [['name', 'slug'], 'unique', 'targetClass' => Category::class, 'filter' => $this->_category ? ['<>', 'id', $this->_category->id] : null]

        ];
    }

    protected function internalForms(): array
    {
        return [
            'meta'
        ];
    }
}
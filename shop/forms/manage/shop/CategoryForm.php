<?php


namespace shop\forms\manage\shop;


use shop\entities\shop\Category;
use shop\forms\CompositeForm;
use shop\forms\manage\MetaForm;
use shop\validators\SlugValidator;
use yii\helpers\ArrayHelper;

class CategoryForm extends CompositeForm
{
    public $name;
    public $slug;
    public $title;
    public $description;
    public $parentId;

    public $code1C;

    private $_category;

    public function __construct(Category $category = null, $config = [])
    {
        if ($category)
        {
            $this->name = $category->name;
            $this->slug = $category->slug;
            $this->title = $category->title;
            $this->description = $category->description;
            $this->parentId = $category->parent ? $category->parent->id : null;
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
    public function parentCategoriesList(): array
    {
        return ArrayHelper::map(
            Category::find()->orderBy('lft')->asArray()->all(),
            'id',
            function (array $category) {
                return ($category['depth'] > 1 ? str_repeat('-- ', $category['depth'] - 1) . ' ' : '') . $category['name'];
            }
        );
    }
    protected function internalForms(): array
    {
        return [
            'meta'
        ];
    }
}
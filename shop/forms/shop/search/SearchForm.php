<?php


namespace shop\forms\shop\search;


use shop\entities\shop\Brand;
use shop\entities\shop\Category;
use shop\entities\shop\Characteristic;
use shop\entities\shop\product\Product;
use shop\entities\shop\product\Value;
use shop\forms\CompositeForm;
use yii\helpers\ArrayHelper;

/**
 * @property ValueForSearchForm[] $values
 */
class SearchForm extends CompositeForm
{

    public $text;
    public $category;
    public $brand;

    public function __construct($config = [])
    {
        /*$this->values = array_map(function (Characteristic $characteristic) {
            return new ValueForSearchForm($characteristic);
        }, Characteristic::find()->orderBy('sort')->all());*/
        $this->values = [];
        parent::__construct($config);
    }

    public function setAttribute($category_id)
    {
        $category = Category::findOne(['id' => $category_id]);
        $categories = Category::find()->select('id')
            ->andWhere(['>=', 'lft', $category->lft])
            ->andWhere(['<=', 'rgt', $category->rgt])
            ->asArray()->column();
        $products = Product::find()->select('id')->andWhere(['category_id' => $categories])->asArray()->column();
        $char_id = Value::find()->select('characteristic_id')->andWhere(['product_id' => $products])->asArray()->column();
        //$attr = Characteristic::find()->andWhere(['id' => $char_id])->orderBy('sort')->all();

        $this->values = array_map(function (Characteristic $characteristic) {
            return new ValueForSearchForm($characteristic);
        }, Characteristic::find()->andWhere(['id' => $char_id])->orderBy('sort')->all());

    }
    public function rules()
    {
        return [
            [['text'], 'string'],
            [['category', 'brand'], 'integer'],
        ];
    }

    public function categoriesList(): array
    {
        return ArrayHelper::map(Category::find()->andWhere(['>', 'depth', 0])->orderBy('lft')->asArray()->all(),
            'id',
            function (array $category) {
                return ($category['depth'] > 1 ? str_repeat('-- ', $category['depth'] - 1) . ' ' : '') . $category['name'];
            }
        );
    }

    public function brandsList(): array
    {
        if (!empty($this->category))
        {
            $category = Category::findOne(['id' => $this->category]);
            $categories = Category::find()->select('id')
                ->andWhere(['>=', 'lft', $category->lft])
                ->andWhere(['<=', 'rgt', $category->rgt])
                ->asArray()->column();
            $products = Product::find()->select('brand_id')
                ->andWhere(['category_id' => $categories])
                ->orderBy('brand_id')->asArray()->column();

            return ArrayHelper::map(Brand::find()->andWhere(['id' => $products])->orderBy('name')->asArray()->all(), 'id', 'name');
        }
        return ArrayHelper::map(Brand::find()->orderBy('name')->asArray()->all(), 'id', 'name');
    }

    public function formName()
    {
        return '';
    }

    protected function internalForms(): array
    {
        return ['values'];
    }
}
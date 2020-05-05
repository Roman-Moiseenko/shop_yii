<?php


namespace shop\forms\shop;


use shop\entities\shop\product\Modification;
use shop\entities\shop\product\Product;
use shop\helpers\PriceHelper;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class AddToCartForm extends Model
{
    public $modification;
    public $quantity;

    private $_product;


    public function __construct(Product $product, $config = [])
    {
        parent::__construct($config);
        $this->_product = $product;
        $this->quantity = 1;
    }

    public function rules()
    {
        return array_filter([
            $this->_product->modifications ? ['modification', 'integer'] : false,
            ['quantity', 'required'],
        ]);
    }

    public function modificationsList(): array
    {
        return ArrayHelper::map($this->_product->modifications, 'id', function (Modification $modification) {
            return $modification->code . ' - ' . $modification->name . ' (' . PriceHelper::format($modification->price ?: $this->_product->price_new) . ')';
        });
    }
}
<?php


namespace shop\forms\shop;


use shop\entities\shop\product\Modification;
use shop\entities\shop\product\Product;
use shop\helpers\PriceHelper;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class AddToCartForm extends Model
{
    /** @var float $quantity */
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
        return [
            ['quantity', 'required'],
            ['quantity', 'integer', 'max' => $this->_product->remains],
        ];
    }
}
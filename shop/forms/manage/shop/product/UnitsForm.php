<?php


namespace shop\forms\manage\shop\product;


use shop\entities\shop\product\Product;
use yii\base\Model;

class UnitsForm extends Model
{
    public $id;
    public $shortname;
    public $fullname;

    public function __construct(Product $product, $config = [])
    {
        if ($product) {
            $this->id = $product->units;
        }
        parent::__construct($config);
    }

}
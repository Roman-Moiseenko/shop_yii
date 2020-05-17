<?php


namespace shop\forms\shop;


use shop\entities\shop\discount\Discount;
use yii\base\Model;

class DiscountForm  extends Model
{

    public $percent;
    public $name;
    public $active;
    public $sort;
    public $_from;
    public $_to;
    public $type_class;

    /**
     * @var Discount
     */

    private $_discount;

    public function __construct(Discount $discount = null, $config = [])
    {
        if ($discount) {
            $this->percent = $discount->percent;
            $this->name = $discount->name;
            $this->active = $discount->active;
            $this->sort = $discount->sort;
            $this->_from = $discount->_from;
            $this->_to = $discount->_to;
            $this->type_class = $discount->type_class;
            $this->_discount = $discount;
        }

        parent::__construct($config);

    }
}
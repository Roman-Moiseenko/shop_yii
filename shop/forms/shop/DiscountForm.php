<?php


namespace shop\forms\shop;


use shop\entities\shop\discount\Discount;
use yii\base\Model;

class DiscountForm  extends Model
{

    public $percent;
    public $name;
    public $active;
    public $_from;
    public $_to;
    public $type_class;

    /**
     * @var Discount
     */

    private $_discount;

    public function rules()
    {
        return [
            [['name', '_from', '_to'], 'string'],
            [['percent'], 'integer', 'max' => 99],
            [['name', '_from', '_to', 'percent', 'type_class', 'active'], 'required'],
        ];
    }

    public function __construct(Discount $discount = null, $config = [])
    {
        if ($discount) {
            $this->percent = $discount->percent;
            $this->name = $discount->name;
            $this->active = $discount->active;
            $this->_from = $discount->_from;
            $this->_to = $discount->_to;
            $this->type_class = $discount->type_class;
            $this->_discount = $discount;
        }
        parent::__construct($config);
    }
}
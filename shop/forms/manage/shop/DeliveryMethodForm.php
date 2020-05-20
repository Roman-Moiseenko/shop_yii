<?php


namespace shop\forms\manage\shop;


use shop\entities\shop\DeliveryMethod;
use yii\base\Model;

class DeliveryMethodForm extends Model
{
    public $name;
    public $cost;
    public $amount_cart_min;

    public function __construct(DeliveryMethod $delivery = null, $config = [])
    {
        if ($delivery) {
            $this->name = $delivery->name;
            $this->cost = $delivery->cost;
            $this->amount_cart_min = $delivery->amount_cart_min;

        }
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['name', 'cost', 'amount_cart_min'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['cost', 'amount_cart_min'], 'integer'],
        ];
    }

}
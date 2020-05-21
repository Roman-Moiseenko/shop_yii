<?php


namespace shop\forms\shop\order;


use shop\entities\shop\DeliveryMethod;
use shop\helpers\PriceHelper;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class DeliveryForm extends Model
{
    public $method;
    public $town;
    public $address;
    private $_amount;

    public function __construct($amount, $config = [])
    {
        $this->_amount = $amount;
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['method'], 'integer'],
            [['town', 'address'], 'string'],
            [['address'], 'required'],
        ];
    }

    public function deliveryMethodList(): array
    {
        $methods = DeliveryMethod::find()->availableForAmount($this->_amount)->orderBy('name')->all();

        return ArrayHelper::map($methods, 'id', function (DeliveryMethod $method) {
            return $method->name . '(' . PriceHelper::format($method->cost) . ')';
        });
    }

}
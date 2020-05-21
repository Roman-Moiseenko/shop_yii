<?php


namespace shop\forms\shop\order;


use shop\entities\shop\DeliveryMethod;
use shop\entities\user\User;
use shop\helpers\PriceHelper;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class DeliveryForm extends Model
{
    public $method;
    public $town;
    public $address;
    private $_amount;

    public function __construct($amount = 0, $config = [])
    {
        $this->_amount = $amount;

        {
            $userId = \Yii::$app->user->id;
            $user = User::findOne($userId);
            $this->town = $user->deliveryData->town;
            $this->address = $user->deliveryData->address;
        }

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

    public function deliveryMethodsList(): array
    {
        $methods = DeliveryMethod::find()->availableForAmount($this->_amount)->orderBy('name')->all();
        return ArrayHelper::map($methods, 'id', function (DeliveryMethod $method) {
            return $method->name . '(' . PriceHelper::format($method->cost) . ')';
        });
    }

}
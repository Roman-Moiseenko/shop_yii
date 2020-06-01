<?php


namespace shop\forms\shop\order;


use shop\entities\shop\order\Order;
use yii\base\Model;

class SetStatusOrderForm extends Model
{

    public $current_status;
    public $cancel_reason;

    public function __construct(Order $order, $config = [])
    {
        $this->current_status = $order->current_status;
        $this->cancel_reason = $order->cancel_reason;
        parent::__construct($config);

    }

    public function rules()
    {
        return [
            [['current_status'], 'integer'],
            [['current_status'], 'required'],
            [['cancel_reason'], 'string'],
        ];
    }

}
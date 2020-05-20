<?php


namespace shop\entities\shop\order;


use shop\entities\shop\DeliveryMethod;
use yii\db\ActiveRecord;
/**
 * @property int $id
 * @property int $created_at
 * @property int $user_id
 * @property int $delivery_method_id
 * @property string $delivery_method_name
 * @property int $delivery_cost
 * @property string $payment_method
 * @property int $cost
 * @property int $note
 * @property int $current_status
 * @property string $cancel_reason
 * @property CustomerData $customerData
 * @property DeliveryData $deliveryData
 *
 * @property OrderItem[] $items
 * @property Status[] $statuses
 */
class Order extends ActiveRecord
{
    public $customerData;
    public $deliveryData;
    public $statuses = [];

    public static function create($userId, CustomerData $customerData, array $items, $cost, $note): self
    {
        $order = new static();
        $order->user_id = $userId;
        $order->customerData = $customerData;
        $order->items = $items;
        $order->cost = $cost;
        $order->note = $note;
        $order->created_at = time();
        $order->addStatus(Status::NEW);

        return $order;
    }

    public function edit(CustomerData $customerData, $note): void
    {
        $this->customerData = $customerData;
        $this->note = $note;
    }

    public function setDeliveryInfo(DeliveryMethod $delivery, DeliveryData $deliveryData)
    {
        $this->delivery_method_id = $delivery->id;
        $this->delivery_method_name = $delivery->name;
        $this->delivery_cost = $delivery->cost;
        $this->deliveryData = $deliveryData;
    }

    public function pay($delivery): void
    {

    }

    public function isCompleted(): bool
    {
        return $this->current_status == Status::COMPLETED;
    }
    public function isCancelled(): bool
    {
        return $this->current_status == Status::CANCELLED;
    }

    public function addStatus($value)
    {
        $this->statuses[] = new Status($value, time());
        $this->current_status = $value;
    }
}
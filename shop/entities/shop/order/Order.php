<?php


namespace shop\entities\shop\order;


use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use shop\entities\shop\DeliveryMethod;
use shop\entities\user\User;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\Json;

/**
 * @property int $id
 * @property int $created_at
 * @property int $user_id
 * @property int $delivery_method_id
 * @property string $delivery_method_name
 * @property int $delivery_cost
 * @property string $payment_method
 * @property float $cost
 * @property float $cost_original
 * @property int $discount
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
    /* @var DeliveryData $deliveryData*/
    public $deliveryData;
    public $statuses = [];

    public static function create($userId, CustomerData $customerData,
                                  array $items, $cost, $note,
                                  $cost_original, $discount): self
    {
        $order = new static();
        $order->user_id = $userId;
        $order->customerData = $customerData;
        $order->items = $items;
        $order->cost = $cost;
        $order->cost_original = $cost_original;
        $order->discount = $discount;
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

    public function pay($method): void
    {
        if ($this->isPaid()) {
            throw new \DomainException('Заказ уже оплачен.');
        }
        $this->payment_method = $method;
        $this->addStatus(Status::PAID);
    }

    public function send(): void
    {
        if ($this->isSent()) {
            throw new \DomainException('Заказ уже отправлен.');
        }
        $this->addStatus(Status::SENT);
    }

    public function complete(): void
    {
        if ($this->isCompleted()) {
            throw new \DomainException('Заказ уже выполнен.');
        }
        $this->addStatus(Status::COMPLETED);
    }

    public function cancel($reason): void
    {
        if ($this->isCancelled()) {
            throw new \DomainException('Заказ уже отменен.');
        }
        $this->cancel_reason = $reason;
        $this->addStatus(Status::CANCELLED);
    }

    public function getTotalCost(): int
    {
        return $this->cost + $this->delivery_cost;
    }

    public function canBePaid(): bool
    {
        return $this->isNew();
    }

    public function isNew(): bool
    {
        return $this->current_status == Status::NEW;
    }

    public function isPaid(): bool
    {
        return $this->current_status == Status::PAID;
    }

    public function isSent(): bool
    {
        return $this->current_status == Status::SENT;
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

    #########################

    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getDeliveryMethod(): ActiveQuery
    {
        return $this->hasOne(DeliveryMethod::class, ['id' => 'delivery_method_id']);
    }

    public function getItems(): ActiveQuery
    {
        return $this->hasMany(OrderItem::class, ['order_id' => 'id']);
    }

    public static function tableName(): string
    {
        return '{{%shop_orders}}';
    }
    public function behaviors(): array
    {
        return [
            [
                'class' => SaveRelationsBehavior::class,
                'relations' => ['items'],
            ],
        ];
    }
    public function transactions(): array
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    public function afterFind(): void
    {
        $this->statuses = array_map(function ($row) {
            return new Status(
                $row['value'],
                $row['created_at']
            );
        }, Json::decode($this->getAttribute('statuses_json')));

        $this->customerData = new CustomerData(
            $this->getAttribute('customer_phone'),
            $this->getAttribute('customer_name')
        );

        $this->deliveryData = new DeliveryData(
            $this->getAttribute('delivery_town'),
            $this->getAttribute('delivery_address')
        );
        parent::afterFind();
    }

    public function beforeSave($insert): bool
    {
        $this->setAttribute('statuses_json', Json::encode(array_map(function (Status $status) {
            return [
                'value' => $status->value,
                'created_at' => $status->created_at,
            ];
        }, $this->statuses)));

        $this->setAttribute('customer_phone', $this->customerData->phone);
        $this->setAttribute('customer_name', $this->customerData->name);

        $this->setAttribute('delivery_town', $this->deliveryData->town);
        $this->setAttribute('delivery_address', $this->deliveryData->address);

        return parent::beforeSave($insert);
    }

}
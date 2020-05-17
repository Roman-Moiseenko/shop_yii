<?php


namespace shop\entities\shop;


use shop\cart\cost\Cost;
use shop\entities\shop\queries\DiscountQuery;
use yii\db\ActiveRecord;

/**
 * @property integer $percent
 * @property string $name
 * @property string $from
 * @property string $to
 * @property bool $active
 * @property integer $sort
 * @property integer $type
 */
class Discount extends ActiveRecord
{
    const DISCOUNT_FULLTIME = 0;
    const DISCOUNT_PERIODTIME = 1;
    const DISCOUNT_COST = 2;

    public static function create($percent, $name, $fromDate, $toDate, $sort): self
    {
        $discount = new static();
        $discount->percent = $percent;
        $discount->name = $name;
        $discount->from = $fromDate;
        $discount->to = $toDate;
        $discount->sort = $sort;
        $discount->active = true;
        return $discount;
    }

    public function edit($percent, $name, $fromDate, $toDate, $sort): void
    {
        $this->percent = $percent;
        $this->name = $name;
        $this->from_date = $fromDate;
        $this->to_date = $toDate;
        $this->sort = $sort;
    }

    public function activate(): void
    {
        $this->active = true;
    }

    public function draft(): void
    {
        $this->active = false;
    }

    public function isEnabled(Cost $cost = null): bool
    {
        //tODO
        //По типу скидки определяем доступность ее
        /// По диапозону даты
        /// Периодичная скидка
        /// По объему от покупи


        return true;
    }

    public static function tableName(): string
    {
        return '{{%shop_discounts}}';
    }

    public static function find(): DiscountQuery
    {
        return new DiscountQuery(static::class);
    }
}
<?php


namespace shop\entities\shop\discount;


use shop\cart\cost\Cost;
use shop\entities\shop\discount\CostEnableDiscount;
use shop\entities\shop\discount\PeriodWeekEnableDiscount;

use shop\entities\shop\discount\EnabledDiscountInterface;
use shop\entities\shop\queries\DiscountQuery;
use yii\db\ActiveRecord;

/**
 * @property integer $percent
 * @property string $name
 * @property string $_from
 * @property string $_to
 * @property bool $active
 * @property integer $sort
 * @property string $type_class
 */
class Discount extends ActiveRecord
{

    public static function create($percent, $name, $from, $to, $sort,  EnabledDiscountInterface $enabledDiscount): self
    {
        $discount = new static();
        $discount->percent = $percent;
        $discount->name = $name;
        $discount->_from = $from;
        $discount->_to = $to;
        $discount->type_class = $enabledDiscount->getType();
        $discount->sort = $sort;
        $discount->active = true;
        return $discount;
    }

    public function edit($percent, $name, $from, $to, $sort,  EnabledDiscountInterface $enabledDiscount): void
    {
        $this->percent = $percent;
        $this->name = $name;
        $this->_from = $from;
        $this->_to = $to;
        $this->type_class = $enabledDiscount->getType();
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

    public function getType(): int
    {
        return $this->type_class;
    }

    public function isEnabled(Cost $cost = null): bool
    {
        $class = __NAMESPACE__ . "\\" . $this->type_class;
        return $class::isEnabled($this, $cost);

        //Переделано под SOLID
        // abstract class EnabledDiscount function isEnabled (Discount $discount, Cost $cost = null): bool
        /*
        $now = time();
        $now_y = date('Y');
        $now_m = date('m');
        $now_w = date('w');

        switch ($this->_type) {
            case self::DISCOUNT_FULLTIME;
                $from = strtotime($this->_from . ' 00:00:00');
                $to = strtotime($this->_to . '23:59:59');
                if ($from <= $now && $now <= $to) return true;
            break;
            case self::DISCOUNT_PERIOD_YEAR;
                $from = strtotime($now_y . '-' . $this->_from . ' 00:00:00');
                $to = strtotime($now_y . '-' . $this->_to . '23:59:59');
                if ($from <= $now && $now <= $to) return true;
                break;
            case self::DISCOUNT_PERIOD_MONTH;
                $from = strtotime($now_y . '-' . $now_m . '-' . $this->_from . ' 00:00:00');
                $to = strtotime($now_y . '-' . $now_m . '-' . $this->_to . '23:59:59');
                if ($from <= $now && $now <= $to) return true;
                break;
            case self::DISCOUNT_PERIOD_WEEK;
                if ((int)$this->_from <= $now_w && $now_w <= (int)$this->_to) return true;
                break;
            case self::DISCOUNT_COST;/// По объему от покупки
                if ((int)$this->_from <= $cost->getOrigin() && $cost->getOrigin() <= (int)$this->_to) return true;
                break;
        }
        return false; */
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
<?php

namespace shop\helpers;

use shop\entities\shop\order\Status;
use shop\entities\shop\product\Product;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class OrderHelper
{
    public static function statusList(): array
    {
        return [
            Status::NEW => 'Новый',
            Status::PAID => 'Оплачен',
            Status::SENT => 'Собран',
            Status::COMPLETED => 'Выполнен',
            Status::CANCELLED => 'Отменен',
            Status::CANCELLED_BY_CUSTOMER => 'Отменен Клиентом',
            Status::WAIT => 'Ожидает подтверждения',
        ];
    }

    public static function statusName($status): string
    {
        return ArrayHelper::getValue(self::statusList(), $status);
    }

    public static function statusLabel($status): string
    {
        switch ($status) {
            case Status::NEW:
                $class = 'label label-primary';
                break;
            case Status::PAID:
                $class = 'label label-danger';
                break;
            case Status::SENT:
                $class = 'label label-warning';
                break;
            case Status::COMPLETED:
                $class = 'label label-success';
                break;
            case Status::CANCELLED_BY_CUSTOMER:
            case Status::CANCELLED:
                $class = 'label label-default';
                break;
            default:
                $class = 'label label-default';
        }

        return Html::tag('span', ArrayHelper::getValue(self::statusList(), $status), [
            'class' => $class,
        ]);
    }
}
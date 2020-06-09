<?php

use shop\entities\shop\order\Order;
use shop\entities\shop\order\OrderItem;
use shop\entities\shop\order\Status;
use shop\helpers\OrderHelper;
use shop\helpers\PriceHelper;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $user \shop\entities\user\User */
/* @var $order Order */
$this->title = 'Уведомление о заказе на сайте';
$host = \Yii::$app->params['frontendHostInfo'];

?>
<div class="verify-email">
    <div class="block">
        <span>
            <span style="font-weight: bold; font-size: 16px">Текущий статус заказа: <span style="color: #5b882c"> <?= OrderHelper::statusName($order->current_status) ?></span></span><br>
            <?php if ($order->current_status == Status::CANCELLED): ?>
                <span>Причина отмены: <?= $order->cancel_reason ?></span><br>
            <?php endif;?>
            <span style="font-weight: bolder">Ваш Заказ:</span>
            <table width="100%" cellpadding="8px" cellspacing="0" border="0" dir="LTR"
                   style="background-color: #ededed; border: 1px solid #0b3e6f;border-radius: 5px;
                   direction: LTR; font-family: 'Trebuchet MS', Helvetica, Arial, sans-serif;">
                <tr>
                    <td width="55%" style="font-weight: bold">Товар</td>
                    <td width="15%" style="font-weight: bold">Цена</td>
                    <td width="15%" style="font-weight: bold">Кол-во</td>
                    <td width="15%" style="font-weight: bold">Сумма</td>
                </tr>
                <?php /* @var $item OrderItem */ ?>
                <?php foreach ($order->items as $item): ?>
                    <tr>
                    <td><?= ($item->product)->name ?></td>
                    <td><?= PriceHelper::format($item->price) ?></td>
                    <td><?= $item->quantity ?></td>
                    <td><?= PriceHelper::format($item->price * $item->quantity) ?></td>
                    </tr>
                <?php endforeach; ?>
                </table>
            <?php if ($order->current_status != Status::CANCELLED_BY_CUSTOMER): ?>
            <p><a style="padding: 7.5px 12px; font-size: 12px; border: 1px solid #cccccc;
	        border-radius: 4px;	box-shadow: inset 0 1px 0 rgba(255,255,255,.2);
            display: inline-block;font-family: 'Open Sans', sans-serif;
            text-decoration: none;user-select: none;touch-action: manipulation;
            cursor: pointer;color: #fff; background-color: #5cb85c;"
             href="<?= $host .'/cabinet/order/view?id=' . $order->id ?>">Посмотреть Заказ в кабинете</a></p>
            <?php endif;?>
            </span>
    </div>
</div>


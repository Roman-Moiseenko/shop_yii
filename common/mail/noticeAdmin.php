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
$host = \Yii::$app->params['backendHostInfo'] . \Yii::$app->params['baseUrl'];

?>
<div class="verify-email">
    <div class="block">
        <span>
            <table width="70%" cellpadding="4px" cellspacing="0" border="0" dir="LTR"
                   style="background-color: #ededed; border: 1px solid #0b3e6f;border-radius: 5px;
                   direction: LTR; font-family: 'Trebuchet MS', Helvetica, Arial, sans-serif;">

                <tr>
                    <td width="35%" style="font-weight: bold">Статус Заказа</td>
                    <td width="65%"><?= OrderHelper::statusName($order->current_status) ?></td>
                </tr>
                <tr>
                    <td style="font-weight: bold">Заказ №</td>
                    <td><?= $order->id ?></td>
                </tr>
                 <tr>
                    <td style="font-weight: bold">Сумма заказа</td>
                    <td><?= PriceHelper::format($order->cost) ?></td>
                </tr>
                <tr>
                    <td colspan="2" style="font-weight: bold;" align="center">Сведения о клиенте</td>
                </tr>
                 <tr>
                    <td style="font-weight: bold">Ф.И.О.</td>
                    <td><?= ($order->user)->fullname->getFullname() ?></td>
                </tr>
                <tr>
                    <td style="font-weight: bold">Телефон</td>
                    <td><?= ($order->user)->phone ?></td>
                </tr>
                 <tr>
                    <td style="font-weight: bold">Доставка</td>
                    <td>
                        <?= $order->delivery_method_name ?><br>
                        <?= $order->delivery_town . ', ' . $order->delivery_address ?>
                    </td>
                </tr>
            </table>
            <br>
            <span style="font-weight: bolder">Содержимое Заказа</span>
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
            <?php if ($order->current_status == Status::NEW || $order->current_status == Status::PAID)?>
            <p><a style="padding: 7.5px 12px; font-size: 12px; border: 1px solid #cccccc;
	        border-radius: 4px;	box-shadow: inset 0 1px 0 rgba(255,255,255,.2);
            display: inline-block;font-family: 'Open Sans', sans-serif;
            text-decoration: none;user-select: none;touch-action: manipulation;
            cursor: pointer;color: #fff; background-color: #5cb85c;"
                  class="btn btn-default" href="<?= $host . '/shop/order/view?id=' . $order->id ?>">Посмотреть Заказ в кабинете Администратора</a></p>
            </span>
    </div>
</div>

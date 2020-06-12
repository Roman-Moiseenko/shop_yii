<?php

use shop\entities\shop\order\Order;
use shop\entities\shop\order\Status;
use shop\helpers\PriceHelper;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $orders Order[] */
?>
<li class="dropdown notifications-menu">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <i class="fa fa-bell-o"></i>
        <span class="label label-warning"><?= count($orders) ?></span>
    </a>
    <ul class="dropdown-menu">
        <li class="header"><?= count($orders) ?> новых заказов</li>
        <li>
            <ul class="menu">
                <?php foreach ($orders as $order): ?>
                    <?php $text = 'Заказ №' . $order->id . ' от ' . date('d-m-Y', $order->created_at);?>
                    <li>
                        <a href="<?= Html::encode(Url::to(['shop/order/view', 'id' => $order->id])) ?>">
                            <?php if ($order->current_status == Status::NEW): ?>
                                <i class="fa fa-cart-plus text-blue"></i><?= $text ?>
                            <?php endif; ?>
                            <?php if ($order->current_status == Status::PAID): ?>
                                <i class="fa fa-shopping-cart text-red"></i><?= $text ?>
                            <?php endif; ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </li>
        <li class="footer"><a href="<?= Html::encode(Url::to(['shop/order'])) ?>">Посмотреть все</a></li>
    </ul>
</li>

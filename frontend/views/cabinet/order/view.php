<?php

use shop\helpers\OrderHelper;
use shop\helpers\PriceHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $order shop\entities\Shop\Order\Order */

$this->title = 'Заказ №' . $order->id;
$this->params['breadcrumbs'][] = ['label' => 'Кабинет', 'url' => ['cabinet/default/index']];
$this->params['breadcrumbs'][] = ['label' => 'Заказы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $order,
        'attributes' => [
            [
                    'attribute' => 'created_at',
                'format' => 'datetime',
                'label' => 'Дата',
              ],
            [
                'attribute' => 'current_status',
                'value' => OrderHelper::statusLabel($order->current_status),
                'format' => 'raw',
                'label' => 'Текущий статус',
            ],
            [
                'attribute' => 'delivery_method_name',
                'label' => 'Доставка',
            ],
            [
                'attribute' => 'deliveryData.town',
                'label' => 'Нас.пункт',
            ],
            [
                'attribute' => 'deliveryData.address',
                'label' => 'Адрес',
            ],
           // ($order->discount != 0) ?
            [
                'attribute' => 'cost_original',
                'value' => PriceHelper::format($order->cost_original),
                'format' => 'raw',
                'label' => 'Сумма',
            ],
            [
                'attribute' => 'discount',
                'value' => PriceHelper::format($order->discount * $order->cost_original / 100),
                'format' => 'raw',
                'label' => 'Скидка',
            ],

            [
                'attribute' => 'cost',
                'value' => PriceHelper::format($order->cost),
                'format' => 'raw',
                'label' => 'К оплате',
            ],
            [
                'attribute' => 'note',
                'label' => 'Комментарий',
                'format' => 'ntext',
            ],
        ],
    ]) ?>

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th class="text-left">Товар</th>
                <th class="text-left">Кол-во</th>
                <th class="text-right">Цена</th>
                <th class="text-right">Сумма</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($order->items as $item): ?>
                <tr>
                    <td class="text-left">
                        <?= Html::encode($item->product_name) ?>
                    </td>
                    <td class="text-left">
                        <?= $item->quantity ?>
                    </td>
                    <td class="text-right"><?= PriceHelper::format($item->price) ?></td>
                    <td class="text-right"><?= PriceHelper::format($item->getCost()) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <?php if ($order->canBePaid()): ?>
        <p>
            <?= Html::a('Оплатить', ['/yandexkassa/payorder', 'id' => $order->id], ['class' => 'btn btn-success']) ?>
        </p>
    <?php endif; ?>

</div>
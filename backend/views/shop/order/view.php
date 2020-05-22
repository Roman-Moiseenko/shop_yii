<?php

use shop\helpers\OrderHelper;
use shop\helpers\PriceHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model shop\entities\shop\order\Order */

$this->title = 'Заказ №:' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Заказы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="order-view">

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить заказ?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <div class="box">
        <div class="box-body">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' =>'created_at',
                'label' => 'Дата заказа',
                'value' => date('d.m.Y', $model->created_at),
            ],
            'delivery_method_name',
            [
                'attribute' =>'delivery_cost',
                'label' => 'Стоимость доставки',
                'value' => PriceHelper::format($model->delivery_cost),
                'format' => 'raw',
            ],
            'payment_method',
            [
                    'attribute' =>'cost',
                'label' => 'Сумма заказа',
                'value' => PriceHelper::format($model->cost),
                'format' => 'raw',
                ],
            'note:ntext',
            [
                'attribute' =>'current_status',
                'label' => 'Текущий статус',
                'value' => OrderHelper::statusLabel($model->current_status),
                'format' => 'raw',
            ],
            'cancel_reason:ntext',
            [
                    'attribute' => 'customer_phone',
                'label' => 'Телефон заказчика',
                ],
            [
                'attribute' => 'customer_name',
                'label' => 'Имя заказчика',
            ],
            [
                'attribute' => 'delivery_town',
                'label' => 'Нас.пункт доставки',
            ],
            [
                'attribute' => 'delivery_address',
                'label' => 'Адрес доставки',
                'format' => 'ntext',
            ],
        ],
    ]) ?>
        </div>
    </div>
    <div class="box">
        <div class="box-body">
            <div class="table-responsive">
                <table class="table table-bordered" style="margin-bottom: 0">
                    <thead>
                    <tr>
                        <th class="text-left">Товар</th>
                        <th class="text-left">Кол-во</th>
                        <th class="text-right">Цена</th>
                        <th class="text-right">Сумма</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($model->items as $item): ?>
                        <tr>
                            <td class="text-left">
                                <?= Html::encode($item->product_code1C) ?><br />
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
        </div>
    </div>

    <div class="box">
        <div class="box-body">
            <div class="table-responsive">
                <table class="table table-bordered" style="margin-bottom: 0">
                    <thead>
                    <tr>
                        <th class="text-left">Дата</th>
                        <th class="text-left">Статус</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($model->statuses as $status): ?>
                        <tr>
                            <td class="text-left">
                                <?= Yii::$app->formatter->asDatetime($status->created_at) ?>
                            </td>
                            <td class="text-left">
                                <?= OrderHelper::statusLabel($status->value) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

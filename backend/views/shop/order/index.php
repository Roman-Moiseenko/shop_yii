<?php

use kartik\widgets\DatePicker;
use shop\entities\shop\order\Order;
use shop\helpers\DeliveryHelper;
use shop\helpers\OrderHelper;
use shop\helpers\PriceHelper;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\forms\shop\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Заказы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-index">


    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'id',
                'label' => '№',
                'options' => ['width' => '50px'],
            ],
            [
                'attribute' => 'created_at',
                'label' => 'Дата',
                'options' => ['width' => '20%'],
                'filter' => DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'date_from',
                    'attribute2' => 'date_to',
                    'type' => DatePicker::TYPE_RANGE,
                    'separator' => '-',
                    'pluginOptions' => [
                        'todayHighLight' => true,
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd',
                    ],
                ]),
                'format' => 'datetime',
                ],
            [
                'attribute' => 'firstname',
                'label' => 'Покупатель',
                'value' => function (Order $model) {
                    return ($model->user)->fullname->getShortname();
                },
            ],
            [
                'attribute' => 'delivery_method_id',
                'label' => 'Доставка',
                'value' => function (Order $model) {
                    return $model->delivery_method_name;
                },
                'filter' => DeliveryHelper::list(),
            ],
            //'payment_method',

            [
                'attribute' => 'cost',
                'value' => function (Order $model) {
                    return PriceHelper::format($model->cost);
                },
                'format' => 'raw',
                'label' => 'Сумма',
                'options' => ['width' => '10%'],
            ],

            [
                'attribute' => 'current_status',
                'value' => function (Order $model) {
                    return OrderHelper::statusLabel($model->current_status);
                },
                'filter' => OrderHelper::statusList(),
                'format' => 'raw',
                'label' => 'Статус',
            ],
            [
                'attribute' => 'customer_phone',
                'label' => 'Телефон',
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>

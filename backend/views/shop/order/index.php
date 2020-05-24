<?php

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

            ],
            [
                'attribute' => 'created_at',
                'label' => 'Дата',
                'format' => 'datetime'],
            [
                'attribute' => 'user_id',
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
               // 'filter' => DeliveryHelper::list(),
            ],
           // 'delivery_method_id',
           // 'delivery_method_name',
            //'delivery_cost',
            //'payment_method',

            [
                'attribute' => 'cost',
                'value' => function (Order $model) {
                    return PriceHelper::format($model->cost);
                },
                'format' => 'raw',
                'label' => 'Сумма',
            ],
            //'note:ntext',
            [
                'attribute' => 'current_status',
                'value' => function (Order $model) {
                    return OrderHelper::statusLabel($model->current_status);
                },
                'filter' => OrderHelper::statusList(),
                'format' => 'raw',
                'label' => 'Статус',
            ],
            //'cancel_reason:ntext',
            //'statuses_json',
            [
                'attribute' => 'customer_phone',
                'label' => 'Телефон',
            ],
            //'customer_name',
            //'delivery_town',
            //'delivery_address:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>

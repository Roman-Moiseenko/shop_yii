<?php

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

            'id',
            'created_at',
            'user_id',
            'delivery_method_id',
            'delivery_method_name',
            //'delivery_cost',
            //'payment_method',
            //'cost',
            //'note:ntext',
            //'current_status',
            //'cancel_reason:ntext',
            //'statuses_json',
            //'customer_phone',
            //'customer_name',
            //'delivery_town',
            //'delivery_address:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>

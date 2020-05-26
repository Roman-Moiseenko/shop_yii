<?php

use shop\entities\Shop\Order\Order;
use shop\helpers\OrderHelper;
use shop\helpers\PriceHelper;
use yii\grid\ActionColumn;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Заказы';
$this->params['breadcrumbs'][] = ['label' => 'Личный кабинет', 'url' => ['cabinet/default/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<span class="attention">Внимание! Не оплаченные заказы, автоматически удаляются в течение 3 дней!</span>
<div class="user-index">

    <div class="box">
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    [
                        'attribute' => 'id',
                        'value' => function (Order $model) {
                            return Html::a(
                                'Заказ № ' .
                                Html::encode($model->id) .
                                ' от ' .
                                \Yii::$app->formatter->asDate($model->created_at),
                                ['view', 'id' => $model->id]);
                        },
                        'format' => 'raw',
                        'label' => 'Заказ',
                    ],
                    [
                        'attribute' => 'cost',
                        'value' => function (Order $model) {
                            return PriceHelper::format($model->cost);
                        },
                        'format' => 'raw',
                        'label' => 'Сумма заказа',
                    ],
                    [
                        'attribute' => 'status',
                        'value' => function (Order $model) {
                            return OrderHelper::statusLabel($model->current_status);
                        },
                        'format' => 'raw',
                        'label' => 'Текущий статус',
                    ],
                    ['class' => ActionColumn::class],
                ],
            ]); ?>
        </div>
    </div>
</div>

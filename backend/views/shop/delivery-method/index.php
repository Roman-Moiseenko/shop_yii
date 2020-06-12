<?php

use shop\entities\shop\DeliveryMethod;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\forms\shop\DeliveryMethodSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Способы доставки';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="delivery-method-index">
    <p>
        <?= Html::a('Добавить доставку', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            ['attribute' => 'name',
                'label' => 'Название',
                'value' => function (DeliveryMethod $model) {
                    return Html::a(Html::encode($model->name), ['view', 'id' => $model->id]);
                },
                'format' => 'raw',
                ],
            ['attribute' => 'cost',
                'label' => 'Стоимость'],
            ['attribute' => 'amount_cart_min',
                'label' => 'Мин. сумма в корзине'],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>

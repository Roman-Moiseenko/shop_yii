<?php

use shop\entities\shop\discount\Discount;
use shop\helpers\DiscountHelper;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\forms\Shop\DiscountSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Скидки';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="discount-index">
    <p>
        <?= Html::a('Создать скидку', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'percent',
                'options' => ['width' => '50px'],
                'value' => function (Discount $discount) {
                    return $discount->percent . ' %';
                },
                'label' => '%%'],
            [
                'attribute' => 'name',
                'label' => 'Название',
                'value' => function (Discount $discount) {
                    return Html::a(Html::encode($discount->name), ['view', 'id' => $discount->id]);
                },
                'format' => 'raw',
            ],
            [
                    'attribute' => 'active',
            'label' => 'Активна',
                'value' => function (Discount $model) {
                    $checked = '';
                    if ($model->active) $checked = 'checked';
                    return '<input type="checkbox" class="discount-check" data-id="' .
                        $model->id . '" value="' . $model->active . '" ' . $checked . '>';
                },

                'format' => 'raw',
                'filter' => [1 => 'Да', 0 => 'Нет'],
                'options' => ['width' => '50px'],
            ],
            [
                'attribute' => '_from',
                'label' => 'Нижн.граница',
                'value' => function (Discount $discount) {
                    return (Discount::getNamespace() . '\\' . $discount->type_class)::getCaption($discount->_from);
                },
                'format' => 'raw',
            ],
            [
                'attribute' => '_to',
                'label' => 'Верхн.граница',
                'value' => function (Discount $discount) {
                    return (Discount::getNamespace() . '\\' . $discount->type_class)::getCaption($discount->_to);
                },
                'format' => 'raw',
            ],
            [
                'attribute' => 'type_class',
                'value' => function (Discount $discount) {
                    return (Discount::getNamespace() . '\\' . $discount->type_class)::getName();
                },
                'filter' => DiscountHelper::discounts(),
                'label' => 'Тип скидки',
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>

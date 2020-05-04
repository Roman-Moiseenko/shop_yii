<?php

use shop\entities\shop\product\Product;
use shop\helpers\PriceHelper;
//use shop\helpers\ProductHelper;
use yii\grid\ActionColumn;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\forms\Shop\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Товары';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <p>
        <?= Html::a('Создать Товар', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <div class="box">
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                /* 'rowOptions' => function (Product $model) {
                     return $model->quantity <= 0 ? ['style' => 'background: #fdc'] : [];
                 },*/
                'columns' => [
                    [
                        'value' => function (Product $model) {
                            return $model->mainPhoto ? Html::img($model->mainPhoto->getThumbFileUrl('file', 'admin')) : null;
                        },
                        'format' => 'raw',
                        'contentOptions' => ['style' => 'width: 100px'],
                    ],
                    [
                        'label' => 'Бренд',
                        'attribute' => 'brand_id',
                        'value' => 'brand.name',
                        'filter' => $searchModel->brandList(),
                    ],
                    [
                        'label' => 'Товар',
                        'attribute' => 'name',
                        'value' => function (Product $model) {
                            return Html::a(Html::encode($model->name), ['view', 'id' => $model->id]);
                        },
                        'format' => 'raw',
                    ],
                    [
                        'label' => 'Категория',
                        'attribute' => 'category_id',
                        'filter' => $searchModel->categoriesList(),
                        'value' => 'category.name',
                    ],
                    [
                        'label' => 'Цена',
                        'attribute' => 'price_new',
                        'value' => function (Product $model) {
                            return PriceHelper::format($model->price_new);
                        },
                        'format' => 'raw'
                    ],
                    [
                        'label' => 'Остаток',
                        'attribute' => 'remains',
                        'value' => function (Product $model) {
                            return $model->remains . ' ' . $model->units;
                        },
                        'filter' => [1 => 'Все', 0 => 'Нет на складе'],
                    ],
                    [
                        'attribute' => 'featured',
                        'label' => 'реком.',
                        'value' => function (Product $model) {
                            $checked = '';
                            if ($model->featured) $checked = 'checked';
                            return '<input type="checkbox" class="featured-check" data-id="' .
                                $model->id . '" value="' . $model->featured . '" ' . $checked . '>';
                        },
                        'format' => 'raw',
                        'filter' => [1 => 'Да', 0 => 'Нет'],
                    ],

                    /*  'quantity',
                      [
                          'attribute' => 'status',
                          'filter' => $searchModel->statusList(),
                          'value' => function (Product $model) {
                              return ProductHelper::statusLabel($model->status);
                          },
                          'format' => 'raw',
                      ],*/
                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
        </div>
    </div>
</div>

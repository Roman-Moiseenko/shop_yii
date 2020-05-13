<?php

/* @var $this yii\web\View */

use shop\entities\Shop\Product\Product;
use shop\helpers\PriceHelper;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;

$this->title = 'Избранное';
$this->params['breadcrumbs'][] = ['label' => 'Кабинет', 'url' => ['cabinet/default/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cabinet-index">
    <h1><?= Html::encode($this->title) ?></h1>
<div class="row">
    <div class="col-sm-12">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'options' => [
                'width' => '100%',
            ],
        'columns' => [
            [
                'value' => function (Product $model) {
                    return $model->mainPhoto ? Html::img($model->mainPhoto->getThumbFileUrl('file', 'admin')) : null;
                },
                'format' => 'raw',
                'contentOptions' => ['style' => 'width: 100px'],
            ],
            'id',
            [
                'attribute' => 'name',
                'value' => function (Product $model) {
                    return Html::a(Html::encode($model->name), ['/shop/catalog/product', 'id' => $model->id]);
                },
                'format' => 'raw',
                'label' => 'Товар',
            ],
            [
                'attribute' => 'price_new',
                'value' => function (Product $model) {
                    return PriceHelper::format($model->price_new);
                },
                'label' => 'Цена',
                'format' => 'raw',
            ],
            [
                'class' => ActionColumn::class,
                'template' => '{delete}',
            ],
        ],
    ]); ?>
    </div>
</div>
</div>

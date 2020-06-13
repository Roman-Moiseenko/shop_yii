<?php

use kartik\widgets\DatePicker;
use shop\entities\blog\post\Post;
use shop\entities\shop\product\Review;
use shop\helpers\PostHelper;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\StringHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\forms\shop\ReviewSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Отзывы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="review-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'id',
                'options' => ['width' => '20px'],
            ],
            [
                'attribute' => 'created_at',
                'label' => 'Дата',
                'format' => 'date',
                'filter' => DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'date_filter',
                    'type' => DatePicker::TYPE_INPUT,
                    'pluginOptions' => [
                        'todayHighLight' => true,
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd',
                    ],
                ]),
                'options' => ['width' => '140px'],
            ],
            [
                'attribute' => 'vote',
                'label' => 'Рейтинг',
                'options' => ['width' => '20px'],
            ],
            [
                'attribute' => 'text',
                'label' => 'Текст',
                'value' => function (Review $model) {
                    return Html::a(StringHelper::truncate(strip_tags($model->text), 100), Url::to(['view', 'id' => $model->id]));
                },
                'format' => 'raw',
            ],
            [
                'attribute' => 'active',
                'label' => 'Статус',
                'filter' => PostHelper::statusList(),
                'value' => function (Review $model) {
                    return PostHelper::statusLabel($model->active);
                },
                'format' => 'raw'
            ],
            [
                'attribute' => 'product_id',
                'label' => 'Товар',
                'value' => function (Review $model) {
                    return StringHelper::truncate(strip_tags($model->product->name), 30);
                },
            ],
        ],
    ]); ?>


</div>

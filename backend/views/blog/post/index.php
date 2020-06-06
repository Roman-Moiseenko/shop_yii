<?php

use kartik\widgets\DatePicker;
use shop\entities\blog\Category;
use shop\entities\blog\post\Post;
use shop\helpers\PostHelper;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\forms\blog\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Посты';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-index">
    <p>
        <?= Html::a('Создать Пост', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'category_id',
                'label' => 'Категории',
                'filter' => $searchModel->categoriesList(),
                'value' => 'category.name',
            ],
            [
                'attribute' => 'created_at',
                'label' => 'Дата создания',
                'format' => 'datetime',
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
            ],
            [
                'attribute' => 'title',
                'label' => 'Заголовок',
                'value' => function (Post $post) {
                    return Html::a(Html::encode($post->title), ['view', 'id' => $post->id]);
                },
                'format' => 'raw',
            ],
            [
                'attribute' => 'status',
                'label' => 'Статус',
                'filter' => PostHelper::statusList(),
                'value' => function (Post $model) {
                    return PostHelper::statusLabel($model->status);
                },
                'format' => 'raw'
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>

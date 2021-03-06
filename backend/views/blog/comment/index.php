<?php

use shop\entities\blog\post\Comment;
use yii\grid\ActionColumn;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $searchModel backend\forms\blog\CommentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Комментарии';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comment-index">
    <div class="box">
        <div class="box-body">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                    'attribute' => 'id',
                'options' => ['width' => '20px'],
                ],
            [
                    'attribute' => 'created_at',
                'label' => 'Дата',
                'format' => 'datetime',
                ],
            [
                'attribute' => 'text',
                'value' => function (Comment $model) {
                    return StringHelper::truncate(strip_tags($model->text), 100);
                },
                'label' => 'Текст',
            ],
            [
                'attribute' => 'active',
                'filter' => $searchModel->activeList(),
                'format' => 'boolean',
                'label' => 'Статус'
            ],
            ['class' => ActionColumn::class],
        ],
    ]); ?>

        </div>
    </div>
</div>

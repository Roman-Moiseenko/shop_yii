<?php

use shop\entities\shop\Tag;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\forms\shop\TagSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Метки';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tag-index">
    <p>
        <?= Html::a('Создать метку', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                    'attribute' => 'name',
                'value' => function (Tag $model) {
                    return Html::a(Html::encode($model->name), ['view', 'id' => $model->id]);
                },
                'label' => 'Имя',
                'format' => 'raw'
            ],
            [
                    'attribute' => 'slug',
                'label' => 'Ссылка',
                ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>

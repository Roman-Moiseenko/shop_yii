<?php

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
                'label' => 'Имя'
            ],
            [
                    'attribute' => 'slug',
                'label' => 'Ссылка',
                ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>

<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\forms\data\ParamsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Параметры';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="params-index">
    <p>
        <?= Html::a('Создать Параметр', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'key',
                'label' => 'Параметр',
                'options' => ['width' => '20%',]
            ],
            [
                'attribute' => 'value',
                'label' => 'Значение',
                'options' => ['width' => '30%',]
            ],
            [
                'attribute' => 'description',
                'label' => 'Описание',
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>

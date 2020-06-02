<?php

use shop\entities\shop\product\Product;
use shop\entities\shop\RegAttribute;
use shop\helpers\ListHelper;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel \backend\forms\data\RegAttributeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Регулярка';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="reg-attribute-index">
    <p>
        <?= Html::a('Создать Регулярку', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'attribute' => 'category_id',
                'filter' => ListHelper::categories(),
                'value' => 'category.name',
                'label' => 'Категория',
            ],
            [
                    'label' => 'Рег.выражение',
                'attribute' => 'reg_match',
                'value' => function (RegAttribute $model) {
                    return Html::a(Html::encode($model->reg_match), ['view', 'id' => $model->id]);
                },
                'format' => 'raw',
            ],
            [
                'attribute' => 'characteristic_id',
                'filter' => ListHelper::characteristics(),
                'value' => 'characteristic.name',
                'label' => 'Атрибут',
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>

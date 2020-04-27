<?php

use shop\entities\shop\Characteristic;
use shop\helpers\CharacteristicHelper;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\forms\shop\CharacteristicSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Атрибуты';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="characteristic-index">
    <p>
        <?= Html::a('Создать Атрибут', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'name',
                'value' => function (Characteristic $model) {
                    return Html::a(Html::encode($model->name), ['view', 'id' => $model->id]);
                },
                'label' => 'Атрибут',
                'format' => 'raw',
            ],
            [
                'attribute' => 'type',
                'filter' => $searchModel->typesList(),
                'value' => function(Characteristic $model) {
                    return CharacteristicHelper::typeName($model->type);
                },
                'label' => 'Тип',
            ],
            [
                'attribute' => 'required',
                'filter' => $searchModel->requiredList(),
                'value' => function (Characteristic $model) {
                    return $model->required == 0 ? 'Нет' : 'Да';
                },

                'label' => 'Обязательное поле',
            ],
            'default',
            //'variants_json',
            //'sort',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>

<?php

use shop\entities\shop\discount\Discount;
use shop\helpers\DiscountHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model shop\entities\shop\discount\Discount */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Скидки', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="discount-view">
    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Удалить скидку?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('Создать скидку', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'percent',
                'label' => '%%'],
            [
                'attribute' => 'name',
                'label' => 'Название',
            ],
            [
                'attribute' => 'active',
                'label' => 'Активна',
                'value' => function (Discount $model) {
                    return $model->active ? 'Да' : 'Нет';
                },
            ],
            [
                'attribute' => '_from',
                'label' => 'Нижн.граница',
                'value' => function (Discount $model) {
                    return (Discount::getNamespace() . '\\' . $model->type_class)::getCaption($model->_from);
                },
                'format' => 'raw',
            ],
            [
                'attribute' => '_to',
                'label' => 'Верхн.граница',
                'value' => function (Discount $model) {
                    return (Discount::getNamespace() . '\\' . $model->type_class)::getCaption($model->_to);
                },
                'format' => 'raw',
            ],
            [
                'attribute' => 'type_class',
                'value' => function (Discount $model) {
                    return (Discount::getNamespace() . '\\' . $model->type_class)::getName();
                },
                'label' => 'Тип скидки',
            ],
        ],
    ]) ?>

</div>

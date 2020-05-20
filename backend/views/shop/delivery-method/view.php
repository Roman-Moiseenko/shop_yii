<?php

use shop\forms\manage\shop\DeliveryMethodForm;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model shop\entities\shop\DeliveryMethod */


$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Способы доставки', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->name;
\yii\web\YiiAsset::register($this);
?>
<div class="delivery-method-view">
    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Удалить доставку?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('Добавить доставку', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            ['attribute' => 'name',
                'label' => 'Название'],
            ['attribute' => 'cost',
                'label' => 'Стоимость'],
            ['attribute' => 'amount_cart_min',
                'label' => 'Мин. сумма в корзине'],
        ],
    ]) ?>

</div>

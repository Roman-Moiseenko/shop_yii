<?php

use shop\entities\shop\Category;
use shop\entities\shop\RegAttribute;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model shop\entities\shop\RegAttribute */
/* @var $reg RegAttribute*/

$this->title = ArrayHelper::getValue($reg, 'characteristic.name');
$this->params['breadcrumbs'][] = ['label' => 'Регулярка', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="reg-attribute-view">

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'category_id',
                'value' => ArrayHelper::getValue($reg, 'category.name'),
                'label' => 'Категория',
                ],
            'reg_match',
            [
                'attribute' => 'characteristic_id',
                'value' => ArrayHelper::getValue($reg, 'characteristic.name'),
                'label' => 'Атрибут',
            ],
        ],
    ]) ?>

</div>

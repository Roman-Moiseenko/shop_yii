<?php

use shop\entities\shop\Characteristic;
use shop\helpers\CharacteristicHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $characteristic shop\entities\shop\Characteristic */

$this->title = $characteristic->name;
$this->params['breadcrumbs'][] = ['label' => 'Атрибуты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="characteristic-view">

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $characteristic->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $characteristic->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Удалить данный Атрибут?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $characteristic,
        'attributes' => [
            'id',
            [
                    'attribute' => 'name',
                'label' => 'Имя Атрибута',
                ],
            [
                'attribute' => 'type',
                'value' => CharacteristicHelper::typeName($characteristic->type),
                'label' => 'Тип Атрибута',
            ],
            [
                'attribute' => 'sort',
                'label' => 'Сортировка',
            ],
            [
                'attribute' => 'required',
                'value' => function (Characteristic $model) {
                    return $model->required == 0 ? 'Нет' : 'Да';
                },
                'label' => 'Обязательное поле',
            ],
            [
                'attribute' => 'default',
                'label' => 'Значение по умолчанию',
            ],
            [
                'attribute' => 'variants',
                'value' => implode(PHP_EOL, $characteristic->variants),
                'format' => 'ntext',
                'label' => 'Варианты',
            ],
        ],
    ]) ?>

</div>

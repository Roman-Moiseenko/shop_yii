<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $params shop\entities\Params */

$this->title = $params->key;
$this->params['breadcrumbs'][] = ['label' => 'Параметры', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="params-view">
    <p>
        <?= Html::a('Изменить', ['update', 'id' => $params->key], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $params->key], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $params,
        'attributes' => [
            [
                'attribute' => 'key',
                'label' => 'Параметр',
            ],
            [
                'attribute' => 'value',
                'label' => 'Значение',
            ],
            [
                'attribute' => 'description',
                'label' => 'Описание',
            ],
        ],
    ]) ?>

</div>

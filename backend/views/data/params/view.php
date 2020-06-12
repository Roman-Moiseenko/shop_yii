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

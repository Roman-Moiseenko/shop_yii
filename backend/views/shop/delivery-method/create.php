<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model shop\entities\shop\DeliveryMethod */

$this->title = 'Добавить способ доставки';
$this->params['breadcrumbs'][] = ['label' => 'Способы доставки', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="delivery-method-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>

<?php

use shop\forms\manage\shop\DeliveryMethodForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $delivery shop\entities\shop\DeliveryMethod */
/* @var $model DeliveryMethodForm */

$this->title = 'Изменить доставку: ' . $delivery->name;
$this->params['breadcrumbs'][] = ['label' => 'Способы доставки', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $delivery->name, 'url' => ['view', 'id' => $delivery->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="delivery-method-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>

<?php

use shop\forms\shop\DiscountForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $discount shop\entities\shop\discount\Discount */
/* @var  $model DiscountForm*/

$this->title = 'Редактировать скидку: ' . $discount->name;
$this->params['breadcrumbs'][] = ['label' => 'Скидки', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $discount->name, 'url' => ['view', 'id' => $discount->id]];
$this->params['breadcrumbs'][] = 'Измменить';
?>
<div class="discount-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

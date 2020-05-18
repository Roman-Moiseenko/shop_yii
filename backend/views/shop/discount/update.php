<?php

use shop\forms\shop\DiscountForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $discount shop\entities\shop\discount\Discount */
/* @var  $model DiscountForm*/

$this->title = 'Update Discount: ' . $discount->name;
$this->params['breadcrumbs'][] = ['label' => 'Discounts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $discount->name, 'url' => ['view', 'id' => $discount->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="discount-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model shop\entities\shop\product\Price */
/* @var $product shop\entities\shop\product\Product */

$this->title = 'Изменение цены для: ' . $product->name ;
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-create">
    <div class="product-form">

        <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($model, 'old')->textInput() ?>
        <?= $form->field($model, 'new')->textInput() ?>
        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>

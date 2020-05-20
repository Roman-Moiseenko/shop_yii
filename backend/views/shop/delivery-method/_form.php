<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model shop\entities\shop\DeliveryMethod */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="delivery-method-form">
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label('Название') ?>
    <?= $form->field($model, 'cost')->textInput()->label('Стоимость') ?>
    <?= $form->field($model, 'amount_cart_min')->textInput()->label('Минимальная сумма в корзине') ?>
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>

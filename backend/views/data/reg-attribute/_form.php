<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model shop\forms\data\RegAttributeForm */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="reg-attribute-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'category_id')->dropDownList($model->categoriesList(), ['promt' => '']) ?>

    <?= $form->field($model, 'reg_match')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'characteristic_id')->dropDownList($model->characteristicList(), ['promt' => '']) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

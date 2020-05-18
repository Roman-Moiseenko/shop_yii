<?php

use shop\helpers\DiscountHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model shop\entities\shop\discount\Discount */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="discount-form">
    <div class="row">
        <div class="col-md-6">
    <?php $form = ActiveForm::begin(); ?>
    <div class="box box-default">
        <div class="box-body">
            <div class="row">
                <div class="col-md-12">
                    <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label('Название') ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'percent')->textInput()->label('Процент') ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'active')->dropDownList([1 => 'Да', 2 => 'Нет'],['prompt' => ''])->label('Активная') ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <?= $form->field($model, 'type_class')->dropDownList(DiscountHelper::discounts(), ['prompt' => ''])->label('Тип скидки') ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, '_from')->textInput(['maxlength' => true])->label('Нижняя граница') ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, '_to')->textInput(['maxlength' => true])->label('Верхняя граница') ?>
                </div>

            </div>
            <div class="hint-block">Для границ формат по датам:<br>
                ДД-ММ-ГГГГ (полный или точный период), ДД-ММ (текущий год), ДД (ежемесячный),
                <br>день нед. 0-6 (0-Вс, 6-Сб)</div>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

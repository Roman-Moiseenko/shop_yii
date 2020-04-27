<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model shop\entities\shop\Characteristic */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="characteristic-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="box box-default">
        <div class="box-body">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label('Имя') ?>
            <?= $form->field($model, 'type')->dropDownList($model->typesList())->label('Тип') ?>
            <?= $form->field($model, 'sort')->textInput(['maxlength' => true])->label('Сортировка') ?>
            <?= $form->field($model, 'required')->checkbox()->label('Обязательный параметр') ?>
            <?= $form->field($model, 'default')->textInput(['maxlength' => true])->label('Значение по умолчанию') ?>
            <?= $form->field($model, 'textVariants')->textarea(['rows' => 6])->label('Варианты') ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

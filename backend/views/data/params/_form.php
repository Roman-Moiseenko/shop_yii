<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model shop\entities\Params */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="params-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'key')->textInput(['maxlength' => true])->label('Параметр')->hint('Только латиницей') ?>
    <?= $form->field($model, 'value')->textInput(['maxlength' => true])->label('Значение') ?>
    <?= $form->field($model, 'description')->textInput(['maxlength' => true])->label('Описание') ?>
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>

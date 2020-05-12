<?php

use kartik\file\FileInput;
use shop\helpers\ListHelper;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = 'Обновить Бренды';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <?php $form = ActiveForm::begin([]); ?>
    <div class="box box-default">
        <div class="box-header with-border">Обновить Бренды (по наличию бренда в имени)</div>

        <div class="form-group">
            <?= Html::submitButton('Обновить', ['class' => 'btn btn-success']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

    <?php $form = ActiveForm::begin([
        'method' => 'post',
    ]); ?>
    <div class="box box-default">
        <div class="box-header with-border">Обновить Бренды (в выбранной категории)</div>
        <div class="row">
            <div class="col-md-3">
                <?= $form->field($model, 'brand')->
                dropDownList(ListHelper::brands(), ['prompt' => ''])->
                label('Бренд')->hint('Назначаемый бренд'); ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'category')
                    ->dropDownList(ListHelper::categories(), ['prompt' => ''])->
                    label('Категория')->hint('Изменяемая категория'); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
            <div class="form-group">
                <?= Html::submitButton('Обновить', ['class' => 'btn btn-success']) ?>
            </div>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>

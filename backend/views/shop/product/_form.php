<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model shop\entities\shop\product\Product */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-form">

    <?php $form = ActiveForm::begin(); ?>


    <?= $form->field($model, 'category_id')->dropDownList() ?>

    <?= $form->field($model, 'brand_id')->dropDownList() ?>

    <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'price_old')->textInput() ?>
    <?= $form->field($model, 'price_new')->textInput() ?>
    <?= $form->field($model, 'code1C')->textInput(['maxlength' => true])->label('Код в 1С') ?>


    <div class="box box-default">
        <div class="box-header with-border">Для SEO</div>
        <div class="box-body">
            <?= $form->field($model->meta, 'title')->textInput()->label('Заголовок')  ?>
            <?= $form->field($model->meta, 'description')->textarea(['rows' => 2])->label('Описание') ?>
            <?= $form->field($model->meta, 'keywords')->textInput()->label('Ключевые слова') ?>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

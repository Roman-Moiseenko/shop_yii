<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model shop\entities\shop\Category */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="category-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="box box-default">
        <div class="box-header with-border">Общие</div>
        <div class="box-body">
    <?= $form->field($model, 'parentId')->dropDownList($model->parentCategoriesList()) ?>
    <?= $form->field($model, 'name')->textInput(['maxlength' => true])->hint('Введите Категорию')->label('Имя') ?>
    <?= $form->field($model, 'slug')->textInput(['maxlength' => true])->hint('Только латиницей')->label('Ссылка') ?>
    <?= $form->field($model, 'title')->textInput(['maxlength' => true])->label('Заголовок') ?>
    <?= $form->field($model, 'description')->textarea(['rows' => 6])->label('Описание') ?>

    <?= $form->field($model, 'code1C')->textInput(['maxlength' => true])->label('Код в 1С') ?>

        </div>
    </div>
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

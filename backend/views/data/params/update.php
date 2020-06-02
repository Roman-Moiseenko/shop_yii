<?php

use shop\forms\data\ParamsForm;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $params shop\entities\Params */
/* @var $model ParamsForm */

$this->title = 'Изменить параметр: ' . $params->key;
$this->params['breadcrumbs'][] = ['label' => 'Params', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $params->key, 'url' => ['view', 'id' => $params->key]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="params-update">

    <div class="params-form">

        <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($model, 'key')->textInput(['maxlength' => true, 'disabled' => 'disabled'])->label('Параметр') ?>
        <?= $form->field($model, 'value')->textInput(['maxlength' => true])->label('Значение') ?>
        <?= $form->field($model, 'description')->textInput(['maxlength' => true])->label('Описание') ?>
        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>

</div>

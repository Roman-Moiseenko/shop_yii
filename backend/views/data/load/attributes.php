<?php

use kartik\file\FileInput;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = 'Обновить Атрибуты';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <p>
<?php $form = ActiveForm::begin([
    'options' => ['enctype'=>'multipart/form-data']
]); ?>
<div class="box box-default">
    <div class="box-header with-border">Обновить Аттрибуты</div>

    <div class="form-group">
        <?= Html::submitButton('Обновить', ['class' => 'btn btn-success']) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>
</div>

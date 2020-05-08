<?php

use kartik\file\FileInput;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

?>

<?php $form = ActiveForm::begin([
    'options' => ['enctype'=>'multipart/form-data']
]); ?>
<div class="box box-default">
    <div class="box-header with-border">Photos</div>
    <div class="box-body">
        <?= $form->field($model, 'files')->fileInput() ?>

    </div>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>

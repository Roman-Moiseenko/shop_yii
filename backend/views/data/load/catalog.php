<?php
/** @var $title string */
use kartik\file\FileInput;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = $title;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

<?php $form = ActiveForm::begin([
    'options' => ['enctype'=>'multipart/form-data']
]); ?>
<div class="box box-default">

    <div class="box-body">
        <?= $form->field($model, 'file_catalog')->fileInput()->label('Выбрать файл *.out') ?>

    </div>
    <div class="form-group">
        <?= Html::submitButton('Загрузить', ['class' => 'btn btn-success']) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>
</div>

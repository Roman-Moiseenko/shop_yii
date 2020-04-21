<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model shop\entities\user\User */

$this->title = 'Create User';
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">
    <div class="box">
        <div class="box-body">
            <div class="user-form">
                <?php $form = ActiveForm::begin(); ?>
                <?= $form->field($model, 'username')->textInput() ?>
                <?= $form->field($model, 'email')->textInput() ?>
                <?= $form->field($model, 'password')->textInput() ?>
                <div class="form-group">
                    <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>

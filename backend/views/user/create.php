<?php

use shop\helpers\UserHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model shop\entities\user\User */

$this->title = 'Создать Пользователя';
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">
    <div class="box">
        <div class="box-body">
            <div class="user-form">
                <?php $form = ActiveForm::begin(); ?>
                <?= $form->field($model, 'username')->textInput()->label('Логин') ?>
                <?= $form->field($model, 'email')->textInput()->label('Почта') ?>
                <?= $form->field($model, 'password')->textInput()->label('Пароль') ?>
                <?= $form->field($model, 'role')->dropDownList(UserHelper::rolesList())->label('Уровень доступа') ?>

                <div class="form-group">
                    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>

<?php

use shop\forms\manage\user\UserEditForm;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $user shop\entities\user\User */
/* @var $model UserEditForm */

$this->title = 'Редактирование пользователя: ' . $user->username;
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $user->username, 'url' => ['view', 'id' => $user->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="user-update">
<div class="">
    <div class="box">
        <div class="box-body">
            <div class="user-form">

                <?php $form = ActiveForm::begin(); ?>

                <?= $form->field($model, 'username')->textInput()->label('Логин') ?>
                <?= $form->field($model, 'email')->textInput()->label('Эл.почта') ?>

                <div class="form-group">
                    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
                </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>
</div>
</div>

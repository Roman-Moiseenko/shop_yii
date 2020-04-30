<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \shop\forms\auth\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Пожалуйста, заполните следующие поля для входа в систему:</p>

    <div class="row">
        <div class="col-sm-6">
            <div class="well">
                <h2>Новый пользователь</h2>
                <p><strong>Зарегистрировать аккаунт</strong></p>
                <p>Создав учетную запись, вы сможете совершать покупки быстрее, быть в курсе состояния заказа и отслеживать ранее сделанные заказы.</p>
                <a href="/site/signup" class="btn btn-primary">Continue</a>
            </div>
            <div class="well"><?= yii\authclient\widgets\AuthChoice::widget(['baseAuthUrl' => ['auth/network/auth']]); ?></div>
        </div>
        <div class="col-sm-6">
            <div class="well">
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                <?= $form->field($model, 'username')->textInput(['autofocus' => true])->label('Логин') ?>

                <?= $form->field($model, 'password')->passwordInput()->label('Пароль') ?>

                <?= $form->field($model, 'rememberMe')->checkbox()->label('Запомнить меня') ?>

                <div style="color:#999;margin:1em 0">
                    Если Вы забыли пароль, о вы можете <?= Html::a('сбросить его', ['auth/reset/request']) ?>.
                    <br>
                    Необходимо подтверждение почты? <?= Html::a('Отправить', ['auth/reset/resend']) ?>
                </div>

                <div class="form-group">
                    <?= Html::submitButton('Войти', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>
</div>

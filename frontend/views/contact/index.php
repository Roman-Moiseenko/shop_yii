<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \shop\forms\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = 'Обратная связь';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-contact">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        Если у Вас возникли вопросы, напишите нам. Мы обязательно Вам ответим.
    </p>
    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>
                <?= $form->field($model, 'name')->textInput(['autofocus' => true])->label('Ваше имя') ?>
                <?= $form->field($model, 'email')->label('Электронная почта') ?>
                <?= $form->field($model, 'subject')->label('Тема') ?>
                <?= $form->field($model, 'body')->textarea(['rows' => 6])->label('Сообщение') ?>
                <?= $form->field($model, 'verifyCodeMy')->widget(Captcha::class, [
                    'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
                ])->label('Введите код с картинки') ?>
                <div class="form-group">
                    <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>

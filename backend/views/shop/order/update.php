<?php

use shop\helpers\OrderHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model shop\entities\shop\order\Order */

$this->title = 'Редактирование заказа: №' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Заказы', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Заказ №' . $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="order-update">
    <div class="order-form">
        <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($model, 'delivery_method_id')->textInput() ?>
        <?= $form->field($model, 'delivery_method_name')->textInput(['maxlength' => true, 'disabled' => 'disabled'])->label('Вид доставки') ?>
        <?= $form->field($model, 'delivery_cost')->textInput(['disabled' => 'disabled'])->label('Стоимость доставки') ?>
        <?= $form->field($model, 'payment_method')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'current_status')->dropDownList(OrderHelper::statusList())->label('Текущий статус') ?>
        <?= $form->field($model, 'cancel_reason')->textarea(['rows' => 3])->label('Причина отмены заказа') ?>
        <?= $form->field($model, 'delivery_town')->textInput(['maxlength' => true, 'disabled' => 'disabled'])->label('Нас.пункт') ?>
        <?= $form->field($model, 'delivery_address')->textInput(['disabled' => 'disabled'])->label('Адрес') ?>
        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>

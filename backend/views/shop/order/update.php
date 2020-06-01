<?php

use shop\forms\shop\order\SetStatusOrderForm;
use shop\helpers\OrderHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model SetStatusOrderForm */
/* @var $order shop\entities\shop\order\Order */


$this->title = 'Редактирование заказа: №' . $order->id;
$this->params['breadcrumbs'][] = ['label' => 'Заказы', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Заказ №' . $order->id, 'url' => ['view', 'id' => $order->id]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="order-update">
    <div class="order-form">
        <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($model, 'current_status')->dropDownList(OrderHelper::statusList())->label('Текущий статус') ?>
        <?= $form->field($model, 'cancel_reason')->textarea(['rows' => 3])->label('Причина отмены заказа') ?>
        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>

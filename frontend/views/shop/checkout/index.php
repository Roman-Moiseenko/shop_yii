<?php

/* @var $this yii\web\View */
/* @var $cart \shop\cart\Cart */
/* @var $model \shop\forms\Shop\Order\OrderForm */

use shop\helpers\PriceHelper;
use shop\helpers\WeightHelper;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Оплата';
$this->params['breadcrumbs'][] = ['label' => 'Каталог', 'url' => ['/shop/catalog/index']];
$this->params['breadcrumbs'][] = ['label' => 'Корзина', 'url' => ['/shop/cart/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cabinet-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
            <tr>
                <td class="text-left">Товар</td>

                <td class="text-left">Кол-во</td>
                <td class="text-right">Цена</td>
                <td class="text-right">Сумма</td>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($cart->getItems() as $item): ?>
                <?php
                $product = $item->getProduct();
                $url = Url::to(['/shop/catalog/product', 'id' => $product->id]);
                ?>
                <tr>
                    <td class="text-left">
                        <a href="<?= $url ?>"><?= Html::encode($product->name) ?></a>
                    </td>

                    <td class="text-left">
                        <?= $item->getQuantity() ?>
                    </td>
                    <td class="text-right"><?= PriceHelper::format($item->getPrice()) ?></td>
                    <td class="text-right"><?= PriceHelper::format($item->getCost()) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <br />

    <?php $cost = $cart->getCost() ?>
    <table class="table table-bordered">
        <tr>
            <td class="text-right"  width="70%"><strong>Итого:</strong></td>
            <td class="text-right"><?= PriceHelper::format($cost->getOrigin()) ?></td>
        </tr>
        <tr>
            <td class="text-right"><strong>К оплате:</strong></td>
            <td class="text-right"><?= PriceHelper::format($cost->getTotal()) ?></td>
        </tr>
    </table>

    <?php $form = ActiveForm::begin() ?>
    <div class="row">
        <div class="col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading">Данные клиента</div>
                <div class="panel-body">
                    <?= $form->field($model->customer, 'phone')->textInput()->label('Телефон') ?>
                    <?= $form->field($model->customer, 'name')->textInput()->label('Ф.И.О.') ?>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">Комментарий к заказу</div>
                <div class="panel-body">
                    <?= $form->field($model, 'note')->textarea(['rows' => 3])->label(false) ?>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading">Доставка</div>
                <div class="panel-body">
                    <?= $form->field($model->delivery, 'method')->dropDownList($model->delivery->deliveryMethodsList(), ['prompt' => '--- Выберите ---', 'encode' => false])->label('Доставка') ?>
                    <?= $form->field($model->delivery, 'town')->textInput()->label('Населенный пункт') ?>
                    <?= $form->field($model->delivery, 'address')->textarea(['rows' => 3])->label('Адрес') ?>
                </div>
            </div>
            <div class="form-group">
                <?= Html::submitButton('Оплатить', ['class' => 'btn btn-primary btn-lg btn-block']) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end() ?>

</div>


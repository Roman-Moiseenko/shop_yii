<?php

use shop\entities\shop\order\Order;
use shop\entities\shop\order\OrderItem;
use shop\entities\shop\order\Status;
use shop\entities\shop\product\Review;
use shop\helpers\OrderHelper;
use shop\helpers\PriceHelper;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $review Review */
$this->title = 'Новый отзыв на сайте';
$host = \Yii::$app->params['backendHostInfo'] . \Yii::$app->params['baseUrl'];

?>
<div class="verify-email">
    <div class="block">
        <span>
            <table width="70%" cellpadding="4px" cellspacing="0" border="0" dir="LTR"
                   style="background-color: #ededed; border: 1px solid #0b3e6f;border-radius: 5px;
                   direction: LTR; font-family: 'Trebuchet MS', Helvetica, Arial, sans-serif;">

                <tr>
                    <td width="20%" style="font-weight: bold">Товар</td>
                    <td width="80%"><?= $review->product->name ?></td>
                </tr>
                <tr>
                    <td style="font-weight: bold">Рейтинг</td>
                    <td><?= $review->vote ?></td>
                </tr>
                 <tr>
                    <td style="font-weight: bold">Текст</td>
                    <td><?= $review->text ?></td>
                </tr>
            </table>
            <br><span style="font-size: medium; color: #9e0505;">Внимание!</span><br>Необходимо активировать отзыв, если он не содержит запрещенной к публикации информации!<br>
            <p><a style="padding: 7.5px 12px; font-size: 12px; border: 1px solid #cccccc;
	        border-radius: 4px;	box-shadow: inset 0 1px 0 rgba(255,255,255,.2);
            display: inline-block;font-family: 'Open Sans', sans-serif;
            text-decoration: none;user-select: none;touch-action: manipulation;
            cursor: pointer;color: #fff; background-color: #5cb85c;"
                  class="btn btn-default" href="<?= $host . '/shop/review/view?id=' . $review->id ?>">Посмотреть Заказ в кабинете Администратора</a></p>
            </span>
    </div>
</div>

<?php

use shop\cart\Cart;
use shop\helpers\ParamsHelper;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $cart integer */
/* @var $wishlist integer */
?>

<ul class="list-inline">
    <li><a href="/contact"><i class="fa fa-phone"></i></a> <span class="hidden-xs hidden-sm hidden-md"><?= ParamsHelper::get('phoneMain')?></span></li>
    <li class="dropdown"><a href="/index.php?route=account/account" title="Мой кабинет" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <span class="hidden-xs hidden-sm hidden-md">Мой кабинет</span> <span class="caret"></span></a>
        <ul class="dropdown-menu dropdown-menu-right">
            <?php if (Yii::$app->user->isGuest): ?>
                <li><a href="<?= Html::encode(Url::to(['/auth/auth/login'])) ?>">Войти</a></li>
                <li><a href="<?= Html::encode(Url::to(['/auth/signup'])) ?>">Регистрация</a></li>
            <?php else: ?>
                <li><a href="<?= Html::encode(Url::to(['/cabinet/default/index'])) ?>">Кабинет</a></li>
                <li><a href="<?= Html::encode(Url::to(['/auth/auth/logout'])) ?>" data-method="post">Выйти</a></li>
            <?php endif; ?>
        </ul>
    </li>
    <li><a href="<?= Url::to(['/cabinet/wishlist/index']) ?>" id="wishlist-total" title="Избранное"><i class="fa fa-heart"></i> <span class="hidden-xs hidden-sm hidden-md">Избранное (<?= $wishlist ?>)</span></a></li>
    <li><a href="<?= Url::to(['/shop/cart/index']) ?>" title="Корзина"><i class="fa fa-shopping-cart"></i> <span class="hidden-xs hidden-sm hidden-md">Корзина (<?= $cart ?>) </span></a></li>
    <?php if ($cart > 0): ?>
    <li><a href="<?= Url::to('/shop/checkout/index') ?>" title="Оплатить"><i class="fa fa-share"></i> <span class="hidden-xs hidden-sm hidden-md">Оплатить</span></a></li>
    <?php endif;?>
</ul>

<?php
/* @var $cart Cart */

use shop\cart\Cart;
use shop\helpers\PriceHelper;
use yii\helpers\Html;
use yii\helpers\Url;

?>
<div id="cart" class="btn-group btn-block">
    <button type="button" data-toggle="dropdown" data-loading-text="Loading..." class="btn btn-inverse btn-block btn-lg dropdown-toggle"><i class="fa fa-shopping-cart"></i>
        <span id="cart-total"><?=$cart->getAmount(); ?> позиции - <?= PriceHelper::format($cart->getCost()->getTotal()); ?></span>
    </button>
    <ul class="dropdown-menu pull-right">
        <li>
            <table class="table table-striped">
                <?php foreach ($cart->getItems() as $item): ?>
                    <?php
                    $product = $item->getProduct();
                    $url = Url::to(['/shop/catalog/product', 'id' => $product->id]);
                    ?>
                <tr>
                    <td class="text-center">
                        <a href="<?= $url ?>">
                            <?php if ($product->mainPhoto): ?>
                                <img src="<?= $product->mainPhoto->getThumbFileUrl('file', 'catalog_product_additional') ?>" alt="" class="img-thumbnail" />
                            <?php endif; ?>
                        </a>
                    </td>
                    <td class="text-left">
                        <a href="<?= $url ?>"><?= Html::encode($product->name) ?></a>
                    </td>
                    <td class="text-right">x <?= $item->getQuantity() ?> <small>(<?=$product->units; ?>)</small></td>
                    <td class="text-right"><?= PriceHelper::format($item->getPrice()) ?></td>
                    <td class="text-center">
                        <button type="button" href="<?= Url::to(['/shop/cart/remove', 'id' => $item->getId()]) ?>" data-method="post" title="Remove" class="btn btn-danger btn-xs"><i class="fa fa-times"></i></button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
        </li>
        <li>
            <div>
                <table class="table table-bordered">
                    <tr>
                        <td class="text-right"><strong>Итого</strong></td>
                        <td class="text-right"><?= PriceHelper::format($cart->getCost()->getOrigin())?></td>
                    </tr>
                    <tr>
                        <?php foreach ($cart->getCost()->getDiscounts() as $discount):?>
                            <td class="text-right"><strong><?= Html::encode($discount->name)?></strong></td>
                            <td class="text-right"><strong><?= $discount->getString()?></strong></td>
                        <?php endforeach;?>
                    </tr>
                    <tr>
                        <td class="text-right"><strong>К оплате</strong></td>
                        <td class="text-right"><?= PriceHelper::format($cart->getCost()->getTotal())?></td>
                    </tr>
                </table>
                <p class="text-right">
                    <a href="<?= Url::to(['/shop/cart/index']) ?>"><strong><i class="fa fa-shopping-cart"></i> В корзину</strong></a>
                    &nbsp;&nbsp;&nbsp;
                    <a href="<?= Url::to('/shop/checkout/index') ?>"><strong><i class="fa fa-share"></i> Оплатить</strong></a></p>
            </div>
        </li>
    </ul>
</div>
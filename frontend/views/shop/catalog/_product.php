<?php
/* @var $product \shop\entities\shop\product\Product */

use shop\helpers\PriceHelper;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\helpers\Url;

$url = Url::to(['product', 'id' => $product->id])
?>

<div class="product-layout product-list col-xs-12">
    <div class="product-thumb">
        <?php if ($product->mainPhoto): ?>
        <div class="image">
            <a href="<?=Html::encode($url)?>">

                <img src="<?=Html::encode($product->mainPhoto->getThumbFileUrl('file', 'catalog_list')) ?>" alt="" class="img-responsive" />
            </a>
        </div>
        <?php endif; ?>
        <div>
            <div class="caption">
                <h4>
                    <a href="<?= Html::encode($url) ?>"><?= Html::encode($product->name) ?></a>
                </h4>
                <p><?= Html::encode(StringHelper::truncateWords(strip_tags($product->description), 20)) ?></p>
                <p class="price">
                    <span class="price-new"><?= PriceHelper::format($product->price_new) ?></span>
                    <?php if ($product->price_old): ?>
                        <span class="price-old"><?= PriceHelper::format($product->price_old) ?></span>
                    <?php endif; ?>
                </p>
                <p class="price">
                    Остаток <?= $product->remains . ' ' . $product->units ?>
                </p>
            </div>
            <div class="button-group">
                <?php if ($product->isAvailable()): ?>
                    <!--a class="" data-toggle="tooltip" title="В корзину" href="<?= Url::to(['/shop/cart/add', 'id' => $product->id]) ?>" data-method="post"><i class="fa fa-shopping-cart"></i> <span class="hidden-xs hidden-sm hidden-md">В корзину</span></a-->
                    <button type="button" data-toggle="tooltip" title="В корзину" href="<?= Url::to(['/shop/cart/add', 'id' => $product->id]) ?>" data-method="post"><i class="fa fa-shopping-cart"></i> <span class="hidden-xs hidden-sm hidden-md">В корзину</span></button>
                <?php else: ?>
                    <button disabled><i class="fa fa-times-circle"></i> Нет на складе</button>
                <?php endif;?>
                <!--a data-toggle="tooltip" title="В избранное" href="<?= Url::to(['/cabinet/wishlist/add', 'id' => $product->id]) ?>" data-method="post"><i class="fa fa-heart"></i></a-->
                <button type="button" data-toggle="tooltip" title="В избранное" href="<?= Url::to(['/cabinet/wishlist/add', 'id' => $product->id]) ?>" data-method="post"><i class="fa fa-heart"></i></button>
                <!--button type="button" data-toggle="tooltip" title="Сравнить" onclick="compare.add('<?= $product->id ?>');"><i class="fa fa-exchange"></i></button-->
            </div>
        </div>
    </div>
</div>

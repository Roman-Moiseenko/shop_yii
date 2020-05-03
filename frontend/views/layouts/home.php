<?php
/* @var $this \yii\web\View */
/* @var $content string */

use frontend\widgets\BrandWidget;
use frontend\widgets\FeaturedProductsWidget; ?>
<?php $this->beginContent('@frontend/views/layouts/main.php') ?>

<div class="row">
    <!-- -->
    <div id="content" class="col-sm-12"><div class="swiper-viewport">
            <div id="slideshow0" class="swiper-container">
                <div class="swiper-wrapper">
                    <div class="swiper-slide text-center"><a href="index.php?route=product/product&amp;path=57&amp;product_id=49">
                            <img src="https://demo.opencart.com/image/cache/catalog/demo/banners/iPhone6-1140x380.jpg" alt="iPhone 6" class="img-responsive" /></a></div>
                    <div class="swiper-slide text-center"><img src="https://demo.opencart.com/image/cache/catalog/demo/banners/MacBookAir-1140x380.jpg" alt="MacBookAir" class="img-responsive" /></div>
                    <div class="swiper-slide text-center"><img src="https://demo.opencart.com/image/cache/catalog/demo/banners/MacBookAir-1140x380.jpg" alt="MacBookAir" class="img-responsive" /></div>
                    <div class="swiper-slide text-center"><img src="https://demo.opencart.com/image/cache/catalog/demo/banners/MacBookAir-1140x380.jpg" alt="MacBookAir" class="img-responsive" /></div>
                    <div class="swiper-slide text-center"><img src="https://demo.opencart.com/image/cache/catalog/demo/banners/MacBookAir-1140x380.jpg" alt="MacBookAir" class="img-responsive" /></div>
                    <div class="swiper-slide text-center"><img src="https://demo.opencart.com/image/cache/catalog/demo/banners/MacBookAir-1140x380.jpg" alt="MacBookAir" class="img-responsive" /></div>
                </div>
            </div>
            <div class="swiper-pagination slideshow0"></div>
            <div class="swiper-pager">
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </div>

        <!-- РЕКОМЕНДУЕМ -->
        <h3>Рекомендуем</h3>
        <?=FeaturedProductsWidget::widget(['limit' => 4]); ?>
        <!-- -->
        <?=BrandWidget::widget(); ?>

    </div>
</div>

<?php $this->endContent() ?>

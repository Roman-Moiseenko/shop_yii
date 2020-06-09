<?php
/* @var $banners array */

use yii\helpers\Html;

?>

<div class="swiper-viewport">
    <div id="slideshow0" class="swiper-container">
        <div class="swiper-wrapper">
            <?php foreach ($banners as $banner): ?>
            <div class="swiper-slide text-center">
                <img src="<?= Html::encode($banner) ?>" alt="ООО Кам-юнити. г.Елизово, 31 км. Мы вас ждем!" class="img-responsive" />
            </div>
            <?php endforeach;?>
        </div>
    </div>
    <div class="swiper-pagination slideshow0"></div>
    <div class="swiper-pager">
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>
</div>

<?php
/* @var $brands \shop\entities\shop\Brand*/

use yii\helpers\Html;
use yii\helpers\Url;

?>

<div class="swiper-viewport">
    <div id="carousel0" class="swiper-container">
        <div class="swiper-wrapper">
            <?php foreach ($brands as $brand): ?>
                <div class="swiper-slide text-center"><a href="<?=Html::encode(Url::to(['/shop/catalog/brand', 'id' => $brand->id]))?>"><h3><?=$brand->name?></h3></a></div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="swiper-pagination carousel0"></div>
    <div class="swiper-pager">
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>
</div>

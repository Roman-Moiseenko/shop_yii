<?php
/* @var $this \yii\web\View */
/* @var $content string */
?>

<?php $this->beginContent('@frontend/views/layouts/main.php') ?>

<div class="row">
    <aside id="column-left" class="col-sm-3 hidden-xs">
        <div class="list-group">
            <a href="https://demo.opencart.com/index.php?route=product/category&amp;path=20" class="list-group-item active">Desktops (13)</a>
            <a href="https://demo.opencart.com/index.php?route=product/category&amp;path=20_26" class="list-group-item">&nbsp;&nbsp;&nbsp;- PC (0)</a>
            <a href="https://demo.opencart.com/index.php?route=product/category&amp;path=20_27" class="list-group-item active">&nbsp;&nbsp;&nbsp;- Mac (1)</a>
            <a href="https://demo.opencart.com/index.php?route=product/category&amp;path=18" class="list-group-item">Laptops &amp; Notebooks (5)</a>
            <a href="https://demo.opencart.com/index.php?route=product/category&amp;path=25" class="list-group-item">Components (2)</a>
            <a href="https://demo.opencart.com/index.php?route=product/category&amp;path=57" class="list-group-item">Tablets (1)</a>
            <a href="https://demo.opencart.com/index.php?route=product/category&amp;path=17" class="list-group-item">Software (0)</a>
            <a href="https://demo.opencart.com/index.php?route=product/category&amp;path=24" class="list-group-item">Phones &amp; PDAs (3)</a>
            <a href="https://demo.opencart.com/index.php?route=product/category&amp;path=33" class="list-group-item">Cameras (2)</a>
            <a href="https://demo.opencart.com/index.php?route=product/category&amp;path=34" class="list-group-item">MP3 Players (4)</a>
        </div>
        <div class="swiper-viewport">
            <div id="banner0" class="swiper-container">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <a href="index.php?route=product/manufacturer/info&amp;manufacturer_id=7">
                            <img src="https://demo.opencart.com/image/cache/catalog/demo/compaq_presario-182x182.jpg" alt="HP Banner" class="img-responsive" />
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </aside>
    <div id="content" class="col-sm-9">
        <?= $content ?>
    </div>
</div>
<?php $this->endContent() ?>



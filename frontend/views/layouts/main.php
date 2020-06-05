<?php

/* @var $this \yii\web\View */
/* @var $content string */


use frontend\widgets\CartWidget;
use frontend\widgets\TopmenuWidget;
use shop\helpers\WishlistHelper;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\ActiveForm;use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php $this->registerCsrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body>
    <?php $this->beginBody() ?>
    <nav id="top">
        <div class="container">
            <div class="pull-left">
            </div>
            <div id="top-links" class="nav pull-right">
                <?= TopmenuWidget::widget()?>
            </div>
        </div>
    </nav>
    <header id="header-top">
        <div class="container">
            <div class="row">
                <div class="col-sm-3">
                    <div id="logo">
                        <a href="<?= Url::home()?>">
                            <img class="logo-image" src="<?= Yii::getAlias('@web/image/info.png') ?>"></a>
                    </div>
                </div>

                <div class="col-sm-6">

                    <?php ActiveForm::begin(['action' => ['/catalog'], 'method' => 'get']) ?>
                    <div id="search" class="input-group">
                        <input type="text" name="search" value="" placeholder="Поиск" class="form-control input-lg" />
                        <span class="input-group-btn">
                        <button type="submit" class="btn btn-default btn-lg">
                            <i class="fa fa-search"></i>
                        </button>
                        </span>
                    </div>

                    <?php ActiveForm::end() ?>
                </div>
                <div class="col-sm-3">
                    <!-- КОРЗИНА ВИДЖЕТ -->
                    <?= CartWidget::widget()?>
                </div>
            </div>
        </div>
    </header>
    <div class="container">
        <nav id="menu" class="navbar">
            <div class="navbar-header">
                <span id="category" class="visible-xs">Меню</span>
                <button type="button" class="btn btn-navbar navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <i class="fa fa-bars"></i>
                </button>
            </div>
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav">
                    <li><a href="<?=Html::encode(Url::to(['site/index']))?>">Главная</a></li>
                    <li><a href="<?=Html::encode(Url::to(['/shop/catalog/index']))?>">Каталог</a></li>
                    <li><a href="<?=Html::encode(Url::to(['/blog/post/index']))?>">Блог</a></li>
                    <li><a href="<?=Html::encode(Url::to(['/contact/index']))?>">Контакты</a></li>
                    <li><a href="<?=Html::encode(Url::to(['/shop/catalog/search']))?>">Поиск</a></li>
                    <li><a href="<?=Html::encode(Url::to(['/shop/catalog/about']))?>">О магазине</a></li>
                </ul>
            </div>
        </nav>
    </div>

    <div id="common-home" class="container">
        <?= Breadcrumbs::widget([

            'homeLink' => [
                'label' => 'Главная',
                'url' => Yii::$app->homeUrl,
                'title' => 'На главную',
            ],
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>

    <footer>
        <div class="container">
            <div class="row">
                <div class="col-sm-3">
                    <h5>Information</h5>
                    <ul class="list-unstyled">
                        <li><a href="https://demo.opencart.com/index.php?route=information/information&amp;information_id=4">About Us</a></li>
                        <li><a href="https://demo.opencart.com/index.php?route=information/information&amp;information_id=6">Delivery Information</a></li>
                        <li><a href="https://demo.opencart.com/index.php?route=information/information&amp;information_id=3">Privacy Policy</a></li>
                        <li><a href="https://demo.opencart.com/index.php?route=information/information&amp;information_id=5">Terms &amp; Conditions</a></li>
                    </ul>
                </div>
                <div class="col-sm-3">
                    <h5>Customer Service</h5>
                    <ul class="list-unstyled">
                        <li><a href="https://demo.opencart.com/index.php?route=information/contact">Contact Us</a></li>
                        <li><a href="https://demo.opencart.com/index.php?route=account/return/add">Returns</a></li>
                        <li><a href="https://demo.opencart.com/index.php?route=information/sitemap">Site Map</a></li>
                    </ul>
                </div>
                <div class="col-sm-3">
                    <h5>Extras</h5>
                    <ul class="list-unstyled">
                        <li><a href="https://demo.opencart.com/index.php?route=product/manufacturer">Brands</a></li>
                        <li><a href="https://demo.opencart.com/index.php?route=account/voucher">Gift Certificates</a></li>
                        <li><a href="https://demo.opencart.com/index.php?route=affiliate/login">Affiliate</a></li>
                        <li><a href="https://demo.opencart.com/index.php?route=product/special">Specials</a></li>
                    </ul>
                </div>
                <div class="col-sm-3">
                    <h5>My Account</h5>
                    <ul class="list-unstyled">
                        <li><a href="https://demo.opencart.com/index.php?route=account/account">My Account</a></li>
                        <li><a href="https://demo.opencart.com/index.php?route=account/order">Order History</a></li>
                        <li><a href="https://demo.opencart.com/index.php?route=account/wishlist">Wish List</a></li>
                        <li><a href="https://demo.opencart.com/index.php?route=account/newsletter">Newsletter</a></li>
                    </ul>
                </div>
            </div>
            <hr>
            <p>Разработано <a href="http://www.mycraft.ru">Моисеенко Роман Александрович</a> &copy; 2020</p>
        </div>
    </footer>

    <?php $this->endBody() ?>
    <script type="text/javascript"><!--
        $('#slideshow0').swiper({
            mode: 'horizontal',
            slidesPerView: 1,
            pagination: '.slideshow0',
            paginationClickable: true,
            nextButton: '.swiper-button-next',
            prevButton: '.swiper-button-prev',
            spaceBetween: 30,
            autoplay: 2500,
            autoplayDisableOnInteraction: true,
            loop: true
        });
        --></script>
    <script type="text/javascript"><!--
        $('#carousel0').swiper({
            mode: 'horizontal',
            slidesPerView: 5,
            pagination: '.carousel0',
            paginationClickable: true,
            nextButton: '.swiper-button-next',
            prevButton: '.swiper-button-prev',
            autoplay: 2500,
            loop: true
        });
        --></script>
    <script type="text/javascript"><!--
        $('#banner0').swiper({
            effect: 'fade',
            autoplay: 2500,
            autoplayDisableOnInteraction: false
        });
        --></script>
    </body>
    </html>
<?php $this->endPage() ?>
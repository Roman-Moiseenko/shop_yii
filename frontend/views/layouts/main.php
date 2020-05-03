<?php

/* @var $this \yii\web\View */
/* @var $content string */


use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
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
            <ul class="list-inline">
                <li><a href="/contact"><i class="fa fa-phone"></i></a> <span class="hidden-xs hidden-sm hidden-md">8-902-463-2757</span></li>
                <li class="dropdown"><a href="/index.php?route=account/account" title="Мой кабинет" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <span class="hidden-xs hidden-sm hidden-md">Мой кабинет</span> <span class="caret"></span></a>
                    <ul class="dropdown-menu dropdown-menu-right">
                        <?php if (Yii::$app->user->isGuest): ?>
                            <li><a href="<?= Html::encode(Url::to(['/auth/auth/login'])) ?>">Login</a></li>
                            <li><a href="<?= Html::encode(Url::to(['/auth/signup/request'])) ?>">Signup</a></li>
                        <?php else: ?>
                            <li><a href="<?= Html::encode(Url::to(['/cabinet/default/index'])) ?>">Cabinet</a></li>
                            <li><a href="<?= Html::encode(Url::to(['/auth/auth/logout'])) ?>" data-method="post">Logout</a></li>
                        <?php endif; ?>
                    </ul>
                </li>
                <li><a href="<?= Url::to(['/cabinet/wishlist/index']) ?>" id="wishlist-total" title="Избранное (0)"><i class="fa fa-heart"></i> <span class="hidden-xs hidden-sm hidden-md">Избранное (0)</span></a></li>
                <li><a href="<?= Url::to(['/shop/cart/index']) ?>" title="Корзина"><i class="fa fa-shopping-cart"></i> <span class="hidden-xs hidden-sm hidden-md">Корзина</span></a></li>
                <li><a href="/index.php?route=checkout/checkout" title="Checkout"><i class="fa fa-share"></i> <span class="hidden-xs hidden-sm hidden-md">Checkout</span></a></li>
            </ul>
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
            <div class="col-sm-6"><div id="search" class="input-group">
                    <input type="text" name="search" value="" placeholder="Search" class="form-control input-lg" />
                    <span class="input-group-btn">
<button type="button" class="btn btn-default btn-lg"><i class="fa fa-search"></i></button>
</span>
                </div></div>
            <div class="col-sm-3"><div id="cart" class="btn-group btn-block">
                    <button type="button" data-toggle="dropdown" data-loading-text="Loading..." class="btn btn-inverse btn-block btn-lg dropdown-toggle"><i class="fa fa-shopping-cart"></i> <span id="cart-total">0 item(s) - $0.00</span></button>
                    <ul class="dropdown-menu pull-right">
                        <li>
                            <p class="text-center">Ваша корзина пуста.</p>
                        </li>
                    </ul>
                </div>
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
        <p>Powered By <a href="http://www.opencart.com">OpenCart</a><br /> Your Store &copy; 2020</p>
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
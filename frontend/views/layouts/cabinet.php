<?php
/* @var $this \yii\web\View */
/* @var $content string */
?>

<?php $this->beginContent('@frontend/views/layouts/main.php') ?>

<div class="row">
    <div id="content" class="col-sm-9">
        <?= $content ?>
    </div>

    <aside id="column-right" class="col-sm-3 hidden-xs">
        <div class="list-group">
            <a href="/account/login" class="list-group-item">Login</a>
            <a href="/account/register" class="list-group-item">Register</a>
            <a href="/account/forgotten" class="list-group-item">Forgotten Password</a>
            <a href="/account/account" class="list-group-item">My Account</a>
            <a href="/account/address" class="list-group-item">Address Book</a>
            <a href="/account/wishlist" class="list-group-item">Wish List</a>
            <a href="/account/order" class="list-group-item">Order History</a>
            <a href="/account/download" class="list-group-item">Downloads</a>
            <a href="/account/recurring" class="list-group-item">Recurring payments</a>
            <a href="/account/reward" class="list-group-item">Reward Points</a>
            <a href="/account/return" class="list-group-item">Returns</a>
            <a href="/account/transaction" class="list-group-item">Transactions</a>
            <a href="/account/newsletter" class="list-group-item">Newsletter</a>
        </div>
    </aside>
</div>
<?php $this->endContent() ?>
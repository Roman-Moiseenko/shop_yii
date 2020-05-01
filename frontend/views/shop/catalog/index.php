<?php
/* @var $this \yii\web\View */

use yii\helpers\Html;


$this->title = 'Каталог';
$this->params['breadcrumbs'][] = $this->title;


?>

<h1><?=Html::encode($this->title)?></h1>

<hr>

<div class="card card-default">
    <div class="card-body">
        <a href="https://demo.opencart.com/index.php?route=product/category&amp;path=18_46">Macs (0)</a> |
        <a href="https://demo.opencart.com/index.php?route=product/category&amp;path=18_45">Windows (0)</a>
    </div>
</div>
<div class="row">
    <div class="col-md-2 col-sm-6 hidden-xs">
        <div class="btn-group btn-group-sm">
            <button type="button" id="list-view" class="btn btn-default" data-toggle="tooltip" title="List"><i class="fa fa-th-list"></i></button>
            <button type="button" id="grid-view" class="btn btn-default" data-toggle="tooltip" title="Grid"><i class="fa fa-th"></i></button>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="form-group"><a href="https://demo.opencart.com/index.php?route=product/compare" id="compare-total" class="btn btn-link">Product Compare (0)</a></div>
    </div>
    <div class="col-md-4 col-xs-6">
        <div class="form-group input-group input-group-sm">
            <label class="input-group-addon" for="input-sort">Sort By:</label>
            <select id="input-sort" class="form-control" onchange="location = this.value;">
                <option value="https://demo.opencart.com/index.php?route=product/category&amp;path=18&amp;sort=p.sort_order&amp;order=ASC" selected="selected">Default</option>
                <option value="https://demo.opencart.com/index.php?route=product/category&amp;path=18&amp;sort=pd.name&amp;order=ASC">Name (A - Z)</option>
                <option value="https://demo.opencart.com/index.php?route=product/category&amp;path=18&amp;sort=pd.name&amp;order=DESC">Name (Z - A)</option>
                <option value="https://demo.opencart.com/index.php?route=product/category&amp;path=18&amp;sort=p.price&amp;order=ASC">Price (Low &gt; High)</option>
                <option value="https://demo.opencart.com/index.php?route=product/category&amp;path=18&amp;sort=p.price&amp;order=DESC">Price (High &gt; Low)</option>
                <option value="https://demo.opencart.com/index.php?route=product/category&amp;path=18&amp;sort=rating&amp;order=DESC">Rating (Highest)</option>
                <option value="https://demo.opencart.com/index.php?route=product/category&amp;path=18&amp;sort=rating&amp;order=ASC">Rating (Lowest)</option>
                <option value="https://demo.opencart.com/index.php?route=product/category&amp;path=18&amp;sort=p.model&amp;order=ASC">Model (A - Z)</option>
                <option value="https://demo.opencart.com/index.php?route=product/category&amp;path=18&amp;sort=p.model&amp;order=DESC">Model (Z - A)</option>
            </select>
        </div>
    </div>
    <div class="col-md-3 col-xs-6">
        <div class="form-group input-group input-group-sm">
            <label class="input-group-addon" for="input-limit">Show:</label>
            <select id="input-limit" class="form-control" onchange="location = this.value;">
                <option value="https://demo.opencart.com/index.php?route=product/category&amp;path=18&amp;limit=15" selected="selected">15</option>
                <option value="https://demo.opencart.com/index.php?route=product/category&amp;path=18&amp;limit=25">25</option>
                <option value="https://demo.opencart.com/index.php?route=product/category&amp;path=18&amp;limit=50">50</option>
                <option value="https://demo.opencart.com/index.php?route=product/category&amp;path=18&amp;limit=75">75</option>
                <option value="https://demo.opencart.com/index.php?route=product/category&amp;path=18&amp;limit=100">100</option>
            </select>
        </div>
    </div>
</div>
<div class="row"> <div class="product-layout product-list col-xs-12">
        <div class="product-thumb">
            <div class="image"><a href="https://demo.opencart.com/index.php?route=product/product&amp;path=18&amp;product_id=47"><img src="https://demo.opencart.com/image/cache/catalog/demo/hp_1-228x228.jpg" alt="HP LP3065" title="HP LP3065" class="img-responsive" /></a></div>
            <div>
                <div class="caption">
                    <h4><a href="https://demo.opencart.com/index.php?route=product/product&amp;path=18&amp;product_id=47">HP LP3065</a></h4>
                    <p>Stop your co-workers in their tracks with the stunning new 30-inch diagonal HP LP3065 Flat Panel Mon..</p>
                    <p class="price"> $122.00
                        <span class="price-tax">Ex Tax: $100.00</span> </p>
                </div>
                <div class="button-group">
                    <button type="button" onclick="cart.add('47', '1');"><i class="fa fa-shopping-cart"></i> <span class="hidden-xs hidden-sm hidden-md">Add to Cart</span></button>
                    <button type="button" data-toggle="tooltip" title="Add to Wish List" onclick="wishlist.add('47');"><i class="fa fa-heart"></i></button>
                    <button type="button" data-toggle="tooltip" title="Compare this Product" onclick="compare.add('47');"><i class="fa fa-exchange"></i></button>
                </div>
            </div>
        </div>
    </div>
    <div class="product-layout product-list col-xs-12">
        <div class="product-thumb">
            <div class="image"><a href="https://demo.opencart.com/index.php?route=product/product&amp;path=18&amp;product_id=43"><img src="https://demo.opencart.com/image/cache/catalog/demo/macbook_1-228x228.jpg" alt="MacBook" title="MacBook" class="img-responsive" /></a></div>
            <div>
                <div class="caption">
                    <h4><a href="https://demo.opencart.com/index.php?route=product/product&amp;path=18&amp;product_id=43">MacBook</a></h4>
                    <p>Intel Core 2 Duo processor
                        Powered by an Intel Core 2 Duo processor at speeds up to 2.16GHz, t..</p>
                    <p class="price"> $602.00
                        <span class="price-tax">Ex Tax: $500.00</span> </p>
                </div>
                <div class="button-group">
                    <button type="button" onclick="cart.add('43', '1');"><i class="fa fa-shopping-cart"></i> <span class="hidden-xs hidden-sm hidden-md">Add to Cart</span></button>
                    <button type="button" data-toggle="tooltip" title="Add to Wish List" onclick="wishlist.add('43');"><i class="fa fa-heart"></i></button>
                    <button type="button" data-toggle="tooltip" title="Compare this Product" onclick="compare.add('43');"><i class="fa fa-exchange"></i></button>
                </div>
            </div>
        </div>
    </div>
    <div class="product-layout product-list col-xs-12">
        <div class="product-thumb">
            <div class="image"><a href="https://demo.opencart.com/index.php?route=product/product&amp;path=18&amp;product_id=44"><img src="https://demo.opencart.com/image/cache/catalog/demo/macbook_air_1-228x228.jpg" alt="MacBook Air" title="MacBook Air" class="img-responsive" /></a></div>
            <div>
                <div class="caption">
                    <h4><a href="https://demo.opencart.com/index.php?route=product/product&amp;path=18&amp;product_id=44">MacBook Air</a></h4>
                    <p>MacBook Air is ultrathin, ultraportable, and ultra unlike anything else. But you don&rsquo;t lose in..</p>
                    <p class="price"> $1,202.00
                        <span class="price-tax">Ex Tax: $1,000.00</span> </p>
                </div>
                <div class="button-group">
                    <button type="button" onclick="cart.add('44', '1');"><i class="fa fa-shopping-cart"></i> <span class="hidden-xs hidden-sm hidden-md">Add to Cart</span></button>
                    <button type="button" data-toggle="tooltip" title="Add to Wish List" onclick="wishlist.add('44');"><i class="fa fa-heart"></i></button>
                    <button type="button" data-toggle="tooltip" title="Compare this Product" onclick="compare.add('44');"><i class="fa fa-exchange"></i></button>
                </div>
            </div>
        </div>
    </div>
    <div class="product-layout product-list col-xs-12">
        <div class="product-thumb">
            <div class="image"><a href="https://demo.opencart.com/index.php?route=product/product&amp;path=18&amp;product_id=45"><img src="https://demo.opencart.com/image/cache/catalog/demo/macbook_pro_1-228x228.jpg" alt="MacBook Pro" title="MacBook Pro" class="img-responsive" /></a></div>
            <div>
                <div class="caption">
                    <h4><a href="https://demo.opencart.com/index.php?route=product/product&amp;path=18&amp;product_id=45">MacBook Pro</a></h4>
                    <p>Latest Intel mobile architecture
                        Powered by the most advanced mobile processors from Intel, ..</p>
                    <p class="price"> $2,000.00
                        <span class="price-tax">Ex Tax: $2,000.00</span> </p>
                </div>
                <div class="button-group">
                    <button type="button" onclick="cart.add('45', '1');"><i class="fa fa-shopping-cart"></i> <span class="hidden-xs hidden-sm hidden-md">Add to Cart</span></button>
                    <button type="button" data-toggle="tooltip" title="Add to Wish List" onclick="wishlist.add('45');"><i class="fa fa-heart"></i></button>
                    <button type="button" data-toggle="tooltip" title="Compare this Product" onclick="compare.add('45');"><i class="fa fa-exchange"></i></button>
                </div>
            </div>
        </div>
    </div>
    <div class="product-layout product-list col-xs-12">
        <div class="product-thumb">
            <div class="image"><a href="https://demo.opencart.com/index.php?route=product/product&amp;path=18&amp;product_id=46"><img src="https://demo.opencart.com/image/cache/catalog/demo/sony_vaio_1-228x228.jpg" alt="Sony VAIO" title="Sony VAIO" class="img-responsive" /></a></div>
            <div>
                <div class="caption">
                    <h4><a href="https://demo.opencart.com/index.php?route=product/product&amp;path=18&amp;product_id=46">Sony VAIO</a></h4>
                    <p>Unprecedented power. The next generation of processing technology has arrived. Built into the newest..</p>
                    <p class="price"> $1,202.00
                        <span class="price-tax">Ex Tax: $1,000.00</span> </p>
                </div>
                <div class="button-group">
                    <button type="button" onclick="cart.add('46', '1');"><i class="fa fa-shopping-cart"></i> <span class="hidden-xs hidden-sm hidden-md">Add to Cart</span></button>
                    <button type="button" data-toggle="tooltip" title="Add to Wish List" onclick="wishlist.add('46');"><i class="fa fa-heart"></i></button>
                    <button type="button" data-toggle="tooltip" title="Compare this Product" onclick="compare.add('46');"><i class="fa fa-exchange"></i></button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-6 text-left"></div>
    <div class="col-sm-6 text-right">Showing 1 to 5 of 5 (1 Pages)</div>
</div>









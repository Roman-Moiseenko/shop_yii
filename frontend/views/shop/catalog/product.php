<?php
/* @var $product \shop\entities\shop\product\Product*/
/* @var $this \yii\web\View */

use frontend\assets\MagnificPopupAsset;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = $product->name;
$this->params['breadcrumbs'][] = ['label' => 'Каталог', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

MagnificPopupAsset::register($this);
?>
<h1><?=Html::encode($product->name)?></h1>

<div class="row">
    <div class="col-sm-8">
        <ul class="thumbnails">
            <?php foreach ($product->photos as $i => $photo): ?>
                <?php if ($i == 0):?>
                    <li>
                        <a class="thumbnail" href="<?=$photo->getUploadedFileUrl('file')?>">
                            <img src="<?=$photo->getThumbFileUrl('file', 'catalog_product_main');?>"
                                 alt="<?=Html::encode($product->name);?>" />
                        </a>
                    </li>
                <?php else: ?>
                    <li class="image-additional">
                        <a class="thumbnail" href="<?=$photo->getUploadedFileUrl('file')?>">&nbsp;
                            <img src="<?=$photo->getThumbFileUrl('file', 'catalog_product_additional');?>"
                                 alt="<?=$product->name;?>" />
                        </a>
                    </li>
                <?php endif; ?>
            <?php endforeach; ?>
        </ul>
        <ul class="nav nav-tabs">
            <li class="active"><a href="#tab-description" data-toggle="tab">Описание</a></li>
            <li><a href="#tab-specification" data-toggle="tab">Характеристики</a></li>
            <li><a href="#tab-review" data-toggle="tab">Отзывы (0)</a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="tab-description"><p>
                    <?=$product->description?></p>
            </div>
            <div class="tab-pane" id="tab-specification">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <td colspan="2"><strong>Memory</strong></td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>test 1</td>
                        <td>16GB</td>
                    </tr>
                    </tbody>
                    <thead>
                    <tr>
                        <td colspan="2"><strong>Processor</strong></td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>No. of Cores</td>
                        <td>4</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="tab-pane" id="tab-review">
                <form class="form-horizontal" id="form-review">
                    <div id="review"></div>
                    <h2>Write a review</h2>
                    <div class="form-group required">
                        <div class="col-sm-12">
                            <label class="control-label" for="input-name">Your Name</label>
                            <input type="text" name="name" value="" id="input-name" class="form-control" />
                        </div>
                    </div>
                    <div class="form-group required">
                        <div class="col-sm-12">
                            <label class="control-label" for="input-review">Your Review</label>
                            <textarea name="text" rows="5" id="input-review" class="form-control"></textarea>
                            <div class="help-block"><span class="text-danger">Note:</span> HTML is not translated!</div>
                        </div>
                    </div>
                    <div class="form-group required">
                        <div class="col-sm-12">
                            <label class="control-label">Rating</label>
                            &nbsp;&nbsp;&nbsp; Bad&nbsp;
                            <input type="radio" name="rating" value="1" />
                            &nbsp;
                            <input type="radio" name="rating" value="2" />
                            &nbsp;
                            <input type="radio" name="rating" value="3" />
                            &nbsp;
                            <input type="radio" name="rating" value="4" />
                            &nbsp;
                            <input type="radio" name="rating" value="5" />
                            &nbsp;Good</div>
                    </div>
                    <div class="buttons clearfix">
                        <div class="pull-right">
                            <button type="button" id="button-review" data-loading-text="Loading..." class="btn btn-primary">Continue</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="btn-group">
            <button type="button" data-toggle="tooltip" class="btn btn-default" title="В Избранное" onclick="wishlist.add('47');">
                <i class="fa fa-heart"></i>
            </button>
            <button type="button" data-toggle="tooltip" class="btn btn-default" title="Сравнить" onclick="compare.add('47');">
                <i class="fa fa-exchange"></i>
            </button>
        </div>
        <h1>HP LP3065</h1>
        <ul class="list-unstyled">
            <li>Бренд: <a href="<?=Html::encode(Url::to(['/shop/catalog/brand', 'id' => $product->brand->id]))?>"><?=$product->brand->name?></a></li>
            <li>Product Code: Product 21</li>
            <li>Reward Points: 300</li>
            <li>Availability: In Stock</li>
        </ul>
        <ul class="list-unstyled">
            <li>
                <h2>$122.00</h2>
            </li>
            <li>Ex Tax: $100.00</li>
            <li>Price in reward points: 400</li>
        </ul>
        <div id="product"> <hr>
            <h3>Available Options</h3>
            <div class="form-group required ">
                <label class="control-label" for="input-option225">Delivery Date</label>
                <div class="input-group date">
                    <input type="text" name="option[225]" value="2011-04-22" data-date-format="YYYY-MM-DD" id="input-option225" class="form-control" />
                    <span class="input-group-btn">
<button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
</span></div>
            </div>
            <div class="form-group">
                <label class="control-label" for="input-quantity">Qty</label>
                <input type="text" name="quantity" value="1" size="2" id="input-quantity" class="form-control" />
                <input type="hidden" name="product_id" value="47" />
                <br />
                <button type="button" id="button-cart" data-loading-text="Loading..." class="btn btn-primary btn-lg btn-block">Add to Cart</button>
            </div>
        </div>
        <div class="rating">
            <p>
                <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-1x"></i></span>&nbsp;
                <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-1x"></i></span>&nbsp;
                <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-1x"></i></span>&nbsp;
                <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-1x"></i></span>&nbsp;
                <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-1x"></i></span>&nbsp;
                <a href="" onclick="$('a[href=\'#tab-review\']').trigger('click'); return false;">0 reviews</a>
                &nbsp;/&nbsp;<a href="" onclick="$('a[href=\'#tab-review\']').trigger('click'); return false;">Write a review</a>
            </p>
            <hr>

            <div class="addthis_toolbox addthis_default_style" data-url="https://demo.opencart.com/index.php?route=product/product&amp;product_id=47">
                <a class="addthis_button_facebook_like" fb:like:layout="button_count">
                </a> <a class="addthis_button_tweet"></a> <a class="addthis_button_pinterest_pinit"></a>
                <a class="addthis_counter addthis_pill_style"></a></div>
            <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-515eeaf54693130e"></script>

        </div>
    </div>
</div>

<!--
<script type="text/javascript">
    $('select[name=\'recurring_id\'], input[name="quantity"]').change(function(){
        $.ajax({
            url: 'index.php?route=product/product/getRecurringDescription',
            type: 'post',
            data: $('input[name=\'product_id\'], input[name=\'quantity\'], select[name=\'recurring_id\']'),
            dataType: 'json',
            beforeSend: function() {
                $('#recurring-description').html('');
            },
            success: function(json) {
                $('.alert-dismissible, .text-danger').remove();

                if (json['success']) {
                    $('#recurring-description').html(json['success']);
                }
            }
        });
    });
    </script>
<script type="text/javascript">
    $('#button-cart').on('click', function() {
        $.ajax({
            url: 'index.php?route=checkout/cart/add',
            type: 'post',
            data: $('#product input[type=\'text\'], #product input[type=\'hidden\'], #product input[type=\'radio\']:checked, #product input[type=\'checkbox\']:checked, #product select, #product textarea'),
            dataType: 'json',
            beforeSend: function() {
                $('#button-cart').button('loading');
            },
            complete: function() {
                $('#button-cart').button('reset');
            },
            success: function(json) {
                $('.alert-dismissible, .text-danger').remove();
                $('.form-group').removeClass('has-error');

                if (json['error']) {
                    if (json['error']['option']) {
                        for (i in json['error']['option']) {
                            var element = $('#input-option' + i.replace('_', '-'));

                            if (element.parent().hasClass('input-group')) {
                                element.parent().after('<div class="text-danger">' + json['error']['option'][i] + '</div>');
                            } else {
                                element.after('<div class="text-danger">' + json['error']['option'][i] + '</div>');
                            }
                        }
                    }

                    if (json['error']['recurring']) {
                        $('select[name=\'recurring_id\']').after('<div class="text-danger">' + json['error']['recurring'] + '</div>');
                    }

                    // Highlight any found errors
                    $('.text-danger').parent().addClass('has-error');
                }

                if (json['success']) {
                    $('.breadcrumb').after('<div class="alert alert-success alert-dismissible">' + json['success'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');

                    $('#cart > button').html('<span id="cart-total"><i class="fa fa-shopping-cart"></i> ' + json['total'] + '</span>');

                    $('html, body').animate({ scrollTop: 0 }, 'slow');

                    $('#cart > ul').load('index.php?route=common/cart/info ul li');
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    });
    </script>
<script type="text/javascript">
    $('.date').datetimepicker({
        language: 'en-gb',
        pickTime: false
    });

    $('.datetime').datetimepicker({
        language: 'en-gb',
        pickDate: true,
        pickTime: true
    });

    $('.time').datetimepicker({
        language: 'en-gb',
        pickDate: false
    });

    $('button[id^=\'button-upload\']').on('click', function() {
        var node = this;

        $('#form-upload').remove();

        $('body').prepend('<form enctype="multipart/form-data" id="form-upload" style="display: none;"><input type="file" name="file" /></form>');

        $('#form-upload input[name=\'file\']').trigger('click');

        if (typeof timer != 'undefined') {
            clearInterval(timer);
        }

        timer = setInterval(function() {
            if ($('#form-upload input[name=\'file\']').val() != '') {
                clearInterval(timer);

                $.ajax({
                    url: 'index.php?route=tool/upload',
                    type: 'post',
                    dataType: 'json',
                    data: new FormData($('#form-upload')[0]),
                    cache: false,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $(node).button('loading');
                    },
                    complete: function() {
                        $(node).button('reset');
                    },
                    success: function(json) {
                        $('.text-danger').remove();

                        if (json['error']) {
                            $(node).parent().find('input').after('<div class="text-danger">' + json['error'] + '</div>');
                        }

                        if (json['success']) {
                            alert(json['success']);

                            $(node).parent().find('input').val(json['code']);
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                    }
                });
            }
        }, 500);
    });
    </script>
<script type="text/javascript">
    $('#review').delegate('.pagination a', 'click', function(e) {
        e.preventDefault();

        $('#review').fadeOut('slow');

        $('#review').load(this.href);

        $('#review').fadeIn('slow');
    });

    $('#review').load('index.php?route=product/product/review&product_id=47');

    $('#button-review').on('click', function() {
        $.ajax({
            url: 'index.php?route=product/product/write&product_id=47',
            type: 'post',
            dataType: 'json',
            data: $("#form-review").serialize(),
            beforeSend: function() {
                $('#button-review').button('loading');
            },
            complete: function() {
                $('#button-review').button('reset');
            },
            success: function(json) {
                $('.alert-dismissible').remove();

                if (json['error']) {
                    $('#review').after('<div class="alert alert-danger alert-dismissible"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '</div>');
                }

                if (json['success']) {
                    $('#review').after('<div class="alert alert-success alert-dismissible"><i class="fa fa-check-circle"></i> ' + json['success'] + '</div>');

                    $('input[name=\'name\']').val('');
                    $('textarea[name=\'text\']').val('');
                    $('input[name=\'rating\']:checked').prop('checked', false);
                }
            }
        });
    });
    </script>//-->
<?php $js = <<<EOD
    $(document).ready(function() {
        $('.thumbnails').magnificPopup({
            type:'image',
            delegate: 'a',
            gallery: {
                enabled: true
            }
        });
    });
EOD;
$this->registerJs($js); ?>





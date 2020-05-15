<?php
/* @var $product \shop\entities\shop\product\Product*/
/* @var $this \yii\web\View */
/* @var $addToCartForm AddToCartForm */
/* @var $reviewForm ReviewForm */

use frontend\assets\MagnificPopupAsset;
use shop\forms\shop\AddToCartForm;
use shop\forms\shop\ReviewForm;
use shop\helpers\PriceHelper;
use shop\helpers\ProductHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = $product->name;
$this->registerMetaTag(['name' => 'description', 'content' => $product->meta->description]);
$this->registerMetaTag(['name' => 'keywords', 'content' => $product->meta->keywords]);
$this->params['breadcrumbs'][] = ['label' => 'Каталог', 'url' => ['index']];
foreach ($product->category->parents as $parent) {
    if (!$parent->isRoot()) {
        $this->params['breadcrumbs'][] = ['label' => $parent->name, 'url' => ['category', 'id' => $parent->id]];
    }
}
$this->params['breadcrumbs'][] = ['label' => $product->category->name, 'url' => ['category', 'id' => $product->category->id]];
$this->params['breadcrumbs'][] = $product->name;

$this->params['active_category'] = $product->category;


MagnificPopupAsset::register($this);
?>
<div class="row" xmlns:fb="http://www.w3.org/1999/xhtml">
    <div class="col-sm-8">
        <ul class="thumbnails">
            <?php foreach ($product->photos as $i => $photo): ?>
                <?php if ($i == 0):?>
                    <li>
                        <a class="thumbnail" href="<?=$photo->getThumbFileUrl('file', 'catalog_origin')?>">
                            <img src="<?=$photo->getThumbFileUrl('file', 'catalog_product_main');?>"
                                 alt="<?=Html::encode($product->name);?>" />
                        </a>
                    </li>
                <?php else: ?>
                    <li class="image-additional">
                        <a class="thumbnail" href="<?=$photo->getThumbFileUrl('file', 'catalog_origin')?>">&nbsp;
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
                    <?=Yii::$app->formatter->asNtext($product->description)?></p>
            </div>
            <div class="tab-pane" id="tab-specification">
                <table class="table table-bordered">
                    <tbody>
                    <?php foreach ($product->values as $value): ?>
                        <?php if (!empty($value->value)): ?>
                            <tr>
                                <th><?= Html::encode($value->characteristic->name) ?></th>
                                <td><?= Html::encode($value->value) ?></td>
                            </tr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="tab-pane" id="tab-review">

                    <div id="review"></div>
                    <h2>Оставить отзыв</h2>
                    <?php if (Yii::$app->user->isGuest): ?>
                    <div class="card">
                        <div class="card-body">
                            Пожалуйста, <?= Html::a('авторизуйтесь', ['/auth/auth/login'])?> для написания отзыва
                        </div>
                    </div>
                    <?php else:?>
                    <?php $form = ActiveForm::begin()?>
                    <?= $form->field($reviewForm, 'vote')->dropDownList($reviewForm->voteList(), ['prompt' => '--- Выберите ---'])->label('Рейтинг'); ?>

                    <?= $form->field($reviewForm, 'text')->textarea(['rows' => 5])->label('Отзыв'); ?>

                        <div class="form-group">
                            <?=Html::submitButton('Отправить', ['class' => 'btn btn-primary btn-lg btn-block'])?>
                        </div>
                    <?php ActiveForm::end()?>
                    <?php endif;?>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="btn-group">
            <button type="button" data-toggle="tooltip" class="btn btn-default"  title="В избранное" href="<?= Url::to(['/cabinet/wishlist/add', 'id' => $product->id]) ?>" data-method="post">
                <i class="fa fa-heart"></i>
            </button>
            <button type="button" data-toggle="tooltip" class="btn btn-default" title="Сравнить" onclick="compare.add('47');">
                <i class="fa fa-exchange"></i>
            </button>
        </div>
        <h1><?=Html::encode($product->name)?></h1> <!-- Заголовок товара-->
        <ul class="list-unstyled">
            <li>Бренд: <a href="<?=Html::encode(Url::to(['/shop/catalog/brand', 'id' => $product->brand->id]))?>"><?=Html::encode($product->brand->name)?></a></li>
            <li>Артикул: <?=$product->code?></li>
            <li>Метки:
                <?php foreach ($product->tags as $tag):?>
                <a href="<?=Html::encode(Url::to(['tag', 'id' => $tag->id]));?>"><?=Html::encode($tag->name)?></a>
                <?php endforeach;?>
            </li>
            <li></li>
        </ul>
        <ul class="list-unstyled">
            <li>
                <h2><?=PriceHelper::format($product->price_new);?></h2>
            </li>
            <li></li>
            <li>На складе: <?=Html::encode(ProductHelper::remains($product));?></li>
        </ul>
        <div id="product" class="required"> <hr>
                <h3></h3>
            <?= Html::beginForm(['/shop/cart/add', 'id' => $product->id]); ?>
            <label class="control-label" for="quantity-product-to-cart">Кол-во</label>
                <input id="quantity-product-to-cart" type="text" name="quantity" value="1" size="1" class="form-control" required />
<p></p>
            <div class="form-group">
                <?=Html::submitButton('В корзину', ['class' => 'btn btn-primary btn-lg btn-block'])?>
            </div>
            <?= Html::endForm() ?>

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





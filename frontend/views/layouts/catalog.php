<?php
/* @var $this \yii\web\View */
/* @var $content string */
use frontend\widgets\CategoriesWidget;?>

<?php $this->beginContent('@frontend/views/layouts/main.php') ?>

<div class="row">
    <aside id="column-left" class="col-sm-3 hidden-xs">

        <?= CategoriesWidget::widget([
                'active' => $this->params['active_category'] ?? null,
           // 'showcount' => true,
        ]); ?>
        <!--div class="swiper-viewport">
            <div id="banner0" class="swiper-container">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        Баннер
                    </div>
                </div>
            </div>
        </div-->

    </aside>
    <div id="content" class="col-sm-9">
        <?= $content ?>
    </div>
</div>
<?php $this->endContent() ?>



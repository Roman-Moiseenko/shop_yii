<?php
/* @var $this \yii\web\View */

/* @var $content string */

use frontend\widgets\BannersWidget;
use frontend\widgets\blog\LastPostsWidget;
use frontend\widgets\BrandWidget;
use frontend\widgets\FeaturedProductsWidget; ?>
<?php $this->beginContent('@frontend/views/layouts/main.php') ?>

<div class="row">
    <!-- -->
    <div id="content" class="col-sm-12">
        <!-- БАННЕРЫ -->
        <div class="hidden-xs">
        <?= BannersWidget::widget(); ?>
        </div>
        <!-- РЕКОМЕНДУЕМ -->
        <h3>Рекомендуем</h3>
        <?= FeaturedProductsWidget::widget(['limit' => 4]); ?>
        <!-- ПОСТЫ -->
        <h3>Последние статьи</h3>
        <?= LastPostsWidget::widget(['limit' => 4]); ?>
        <!-- БРЕНДЫ -->
        <div class="hidden-xs">
        <?= BrandWidget::widget(['limit' => 10]); ?>
        </div>
    </div>
</div>

<?php $this->endContent() ?>

<?php
/* @var $this \yii\web\View */
/* @var $content string */

use frontend\widgets\BannersWidget;
use frontend\widgets\BrandWidget;
use frontend\widgets\FeaturedProductsWidget; ?>
<?php $this->beginContent('@frontend/views/layouts/main.php') ?>

<div class="row">
    <!-- -->
    <div id="content" class="col-sm-12">
        <?= BannersWidget::widget();?>
        <!-- РЕКОМЕНДУЕМ -->
        <h3>Рекомендуем</h3>
        <?=FeaturedProductsWidget::widget(['limit' => 4]); ?>
        <!-- -->
        <?=BrandWidget::widget(); ?>

    </div>
</div>

<?php $this->endContent() ?>

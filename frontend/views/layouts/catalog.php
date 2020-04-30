<?php
/* @var $this \yii\web\View */
/* @var $content string */
?>

<?php $this->beginContent('@frontend/views/layouts/main.php') ?>

<div class="row">
    <aside id="column-left" class="col-sm-3 hidden-xs">
        <div class="list-group">
            <a href="https://demo.opencart.com/index.php?route=product/category&amp;path=25_29">Mice and Trackballs (0)</a>
            <a href="https://demo.opencart.com/index.php?route=product/category&amp;path=25_28">Monitors (2)</a>
            <a href="https://demo.opencart.com/index.php?route=product/category&amp;path=25_30">Printers (0)</a>
            <a href="https://demo.opencart.com/index.php?route=product/category&amp;path=25_31">Scanners (0)</a>
            <a href="https://demo.opencart.com/index.php?route=product/category&amp;path=25_32">Web Cameras (0)</a>
        </div>
    </aside>
    <div id="content" class="col-sm-9">
        <?= $content ?>
    </div>
</div>
<?php $this->endContent() ?>
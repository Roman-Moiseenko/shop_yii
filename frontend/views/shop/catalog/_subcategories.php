<?php
/* @var $category \shop\entities\shop\Category*/
?>

<?php

use yii\helpers\Html;
use yii\helpers\Url;

if ($category->children):?>
    <div class="card card-default">
        <div class="card-body">
            <?php foreach ($category->children as $child): ?>
                <a href="<?= Html::encode(Url::to(['/shop/catalog/category', 'id' => $child->id])) ?>"><?= Html::encode($child->name) ?></a>&nbsp;|
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>

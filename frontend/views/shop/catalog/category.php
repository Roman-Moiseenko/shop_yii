<?php
/* @var $this \yii\web\View */
/* @var $category \shop\entities\shop\Category*/
$this->title = $category->getSeoTile();
$this->registerMetaTag(['name' => 'description', 'content' => $category->meta->description]);
$this->registerMetaTag(['name' => 'keywords', 'content' => $category->meta->keywords]);

$this->params['breadcrumbs'][] = ['label' => 'Каталог', 'url' => ['index']];
foreach ($category->parents as $parent) {
    if (!$parent->isRoot()) {
        $this->params['breadcrumbs'][] = ['label' => $parent->name, 'url' => ['category', 'id' => $parent->id]];
    }
}
$this->params['breadcrumbs'][] = $category->name;
$this->params['active_category'] = $category;


use yii\helpers\Html; ?>

<h1><?=Html::encode($category->getHeadingTile())?></h1>
<hr/>
<?= $this->render('_subcategories', ['category' =>$category]); ?>
<?php if ($category->description):?>
<div class="card">
    <div class="card-body">
        <?=Yii::$app->formatter->asNtext($category->description);?>
    </div>
</div>
<?php endif;?>
<?= $this->render('_list', ['dataProvider' => $dataProvider]); ?>

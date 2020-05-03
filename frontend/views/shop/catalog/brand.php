<?php
/* @var $this \yii\web\View */
/* @var $brand \shop\entities\shop\Brand*/
$this->title = $brand->getSeoTile();
$this->registerMetaTag(['name' => 'description', 'content' => $brand->meta->description]);
$this->registerMetaTag(['name' => 'keywords', 'content' => $brand->meta->keywords]);

$this->params['breadcrumbs'][] = ['label' => 'Бренд', 'url' => ['index']];
$this->params['breadcrumbs'][] = $brand->name;
use yii\helpers\Html; ?>
<h1>Товары под брендом &laquo;<?=Html::encode($brand->name)?>&raquo;</h1>
<hr/>
<?= $this->render('_list', ['dataProvider' => $dataProvider]); ?>

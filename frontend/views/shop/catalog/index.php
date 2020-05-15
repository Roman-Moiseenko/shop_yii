<?php
/* @var $this \yii\web\View */
/* @var $category \shop\entities\shop\Category*/

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
$this->title = 'Каталог';
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?=Html::encode($category->getHeadingTile())?></h1>
<hr>
<?= $this->render('_subcategories', ['category' =>$category]); ?>
<?= $this->render('_list', ['dataProvider' => $dataProvider]); ?>




<?php
/* @var $this \yii\web\View */
/* @var $tag \shop\entities\shop\Tag*/
$this->title = $tag->name;

$this->registerMetaTag(['name' => 'keywords', 'content' => $tag->name]);

$this->params['breadcrumbs'][] = ['label' => 'Метка', 'url' => ['index']];
$this->params['breadcrumbs'][] = $tag->name;
use yii\helpers\Html; ?>
<h1>Товары с меткой &laquo;<?=Html::encode($tag->name)?>&raquo;</h1>
<hr/>
<?= $this->render('_list', ['dataProvider' => $dataProvider]); ?>

<?php

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\DataProviderInterface */
/* @var $tag shop\entities\Shop\Tag */

use yii\helpers\Html;

$this->title = 'Посты с тегомg ' . $tag->name;

$this->params['breadcrumbs'][] = ['label' => 'Блог', 'url' => ['index']];
$this->params['breadcrumbs'][] = $tag->name;
?>

<h1>Посты с тегом &laquo;<?= Html::encode($tag->name) ?>&raquo;</h1>

<?= $this->render('_list', [
    'dataProvider' => $dataProvider
]) ?>



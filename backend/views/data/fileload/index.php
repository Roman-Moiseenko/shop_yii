<?php


use shop\entities\shop\loaddata\File;
use shop\helpers\FileRowHelper;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\forms\data\FileloadSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Лог загрузки с 1С';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="file-index">


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'id',
                'options' => ['width' => '20px'],
            ],
            [
                'attribute' => 'file_name',
                'label' => 'Файл загрузки',
                'value' => function (File $file) {
                    return Html::a(Html::encode($file->file_name), ['view', 'id' => $file->id]);
                },
                'format' => 'raw',
            ],
            [
                'attribute' => 'type_data',
                'label' => 'Тип загрузки',
                'value' => function (File $file) {
                    return FileRowHelper::nameTypeFile($file->type_data);
                },
                'filter' => FileRowHelper::listTypeFile(),
            ],
            [
                'attribute' => 'created_at',
                'format' => 'datetime',
                'label' => 'Дата загрузки',
            ],
            ['attribute' => 'count_rows',
                'label' => 'Кол-во загруженных строк'],

            ['class' => 'yii\grid\ActionColumn',
                'template' => '{view} {delete}',],
        ],
    ]); ?>


</div>

<?php

use shop\entities\shop\loaddata\File;
use shop\helpers\FileRowHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $file shop\entities\shop\loaddata\File */

$this->title = $file->file_name;
$this->params['breadcrumbs'][] = ['label' => 'Загрузка с 1С', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="file-view">
    <p>
        <?= Html::a('Delete', ['delete', 'id' => $file->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Удалить данные?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <div class="box">
        <div class="box-body">
            <?= DetailView::widget([
                'model' => $file,
                'attributes' => [
                    'id',
                    [
                        'attribute' => 'file_name',
                        'label' => 'Файл загрузки',
                    ],
                    [
                        'attribute' => 'type_data',
                        'label' => 'Тип загрузки',
                        'value' => FileRowHelper::nameTypeFile($file->type_data),
                    ],
                    [
                        'attribute' => 'created_at',
                        'format' => 'datetime',
                        'label' => 'Дата загрузки',
                    ],
                    ['attribute' => 'count_rows',
                        'label' => 'Кол-во загруженных строк'],
                ],
            ]) ?>
        </div>
    </div>
    <div class="box">

        <div class="box-body">
            <div class="table-responsive">
                <table class="table table-bordered" style="margin-bottom: 0">
                    <thead>
                    <tr>
                        <th width="25%"  class="text-left">Тип изменений</th>
                        <th width="75%"  class="text-left">Изменения</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php foreach ($file->rows as $row): ?>
                        <tr>
                            <td class="text-left">
                                <?= FileRowHelper::nameTypeRow($row->type_data) ?>
                            </td>
                            <td class="text-left">
                                <?= FileRowHelper::jsonToArray($row->load_row); ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

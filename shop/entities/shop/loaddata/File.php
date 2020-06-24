<?php

namespace shop\entities\shop\loaddata;

use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class File
 * @package shop\entities\shop\loaddata
 * @property string $file_name
 * @property integer $type_data
 * @property integer $created_at
 * @property integer $count_rows
 * @property Row[] $rows
 */
class File extends ActiveRecord
{
    const TYPEDATA_CATEGORY = 1;
    const TYPEDATA_PRODUCT = 2;

    public static function create($file_name, $type_data): self
    {
        $file = new  static();
        $file->created_at = time();
        $file->file_name = $file_name;
        $file->type_data = $type_data;
        return $file;
    }

    public function setName($file_name)
    {
        $this->file_name = $file_name;
    }

    public function addRow($type_data, $load_row): Row
    {
        $rows = $this->rows;
        $row = Row::create($type_data, $load_row);
        $rows[] = $row;
        $this->rows = $rows;
        $this->count_rows = count($rows);
        return $row;
    }

    public static function tableName()
    {
        return '{{%shop_files}}';
    }

    public function behaviors()
    {
        return [
            [
                'class' => SaveRelationsBehavior::class,
                'relations' => [
                    'rows',
                ],
            ],
        ];
    }

    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    public function getRows(): ActiveQuery
    {
        return $this->hasMany(Row::class, ['parent_id' => 'id']);
    }
}
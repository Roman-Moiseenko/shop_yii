<?php


namespace shop\entities\shop\loaddata;


use shop\entities\shop\Category;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class Row
 * @package shop\entities\shop\loaddata
 * @property integer $parent_id
 * @property int $type_data
 * @property string $load_row
 * @property Category $category
 */

class Row extends ActiveRecord
{
    const TYPEDATA_CREATE = 1;
    const TYPEDATA_UPDATE = 2;
    const TYPEDATA_HIDE = 3;
    const TYPEDATA_REMOVE = 4;


    public static function create($type_data, $load_row): self
    {
        $row = new static();
        $row->type_data = $type_data;
        $row->load_row = $load_row;
        return $row;
    }

    public static function tableName()
    {
        return '{{%shop_rows}}';
    }
}
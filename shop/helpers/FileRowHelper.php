<?php


namespace shop\helpers;


use shop\entities\shop\Category;
use shop\entities\shop\loaddata\File;
use shop\entities\shop\loaddata\Row;
use yii\helpers\ArrayHelper;

class FileRowHelper
{
    public static function listTypeFile(): array
    {
        return [
            File::TYPEDATA_CATEGORY => 'Каталоги',
            File::TYPEDATA_PRODUCT => 'Товары',
        ];
    }

    public static function nameTypeFile($type_data): string
    {
        return ArrayHelper::getValue(self::listTypeFile(), $type_data);
    }

    public static function listTypeRow(): array
    {
        return [
            Row::TYPEDATA_CREATE => 'Создан',
            Row::TYPEDATA_UPDATE => 'Изменен',
            Row::TYPEDATA_HIDE => 'Скрыт',
            Row::TYPEDATA_REMOVE => 'Удален',
        ];
    }

    public static function nameTypeRow($type_data): string
    {
        return ArrayHelper::getValue(self::listTypeRow(), $type_data);
    }

    public static function jsonToArray($json)
    {
        $array = json_decode($json, true);
        $result = '';
        foreach ($array as $key => $value) {
            if ($key == 'parent_id') {
                $name = (Category::findOne((int)$value))->name;
                $result .= '[' . $key . '] => ' . $name . '<br>';
            } else {
                $result .= '[' . $key . '] => ' . $value . '<br>';
            }
        }
        return $result;
    }
}
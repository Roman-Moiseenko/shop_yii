<?php


namespace shop\helpers;


use shop\entities\Params;

class ParamsHelper
{
    public static function get($key): string
    {
        $params = Params::findOne($key);
        return $params->value;
    }

}
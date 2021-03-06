<?php


namespace shop\helpers;


use shop\entities\Params;

class ParamsHelper
{
    public static function get($key):? string
    {
        if (!$params = Params::findOne($key)) {
            return null;
        }
        return $params->value;
    }

}
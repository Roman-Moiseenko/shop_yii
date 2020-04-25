<?php


namespace shop\services;


class TransactionManager
{
    public function wrap(callable $function):void
    {
        try {
            \Yii::$app->db->transaction($function);
        } catch (\Throwable $e) {
        }
    }

}
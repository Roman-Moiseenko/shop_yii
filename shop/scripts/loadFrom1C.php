<?php
const TIME_LIMIT = 1000;

define('ROOT', 'kupi41.ru/');
define('ROOT_LOAD', 'static.kupi41.ru/exchange/in/');


//Ищем файлы с по маске
$loadcatalog = glob(ROOT_LOAD . '*.groups'); //Группы товаров
$loadproduct = glob(ROOT_LOAD . '*.goods'); //Товары
$loadorder = glob(ROOT_LOAD . '*.order'); //Свойства

//Загрузка групп
foreach (['loadcatalog','loadproduct','loadorder'] as $__ITEMS__) {
    foreach ($$__ITEMS__ as $file) {
        $dataarray = array();
        $fp = fopen($file, 'rt');         // Считываем данные
        if ($fp) {
            while (!feof($fp)) {
                $dataarray[] = rtrim(fgets($fp));
            }
        }
        fclose($fp);
        //Лог загрузки
        $file_log = fopen(ROOT . 'logdata.txt', 'a');
        fwrite($file_log, $__ITEMS__ . "\n\r");
        fwrite($file_log, $file . "\n\r");
        fwrite($file_log, 'кол-во строк '. count($dataarray) . "\n\r");
        fclose($file_log);

        try {
            if (count($dataarray) != 0) Admin::$__ITEMS__($dataarray); // Запускаем соответствующую процедуру класса Админ
            unlink($file); // Удаляем файл
        } catch (Exception $e) {
            $file_error = fopen(ROOT . 'myerrors_load.txt', 'a');
            fwrite($file_error, $__ITEMS__ . "\n\r");
            fwrite($file_error, $file . "\n\r");
            fwrite($file_error, 'Файл '. $e->getFile() . ' строка ' . $e->getLine() . ' текст - '
                . $e->getMessage() . "\n\r" . $e->getCode() . "\n\r");
            foreach ($dataarray as $item) {
                fwrite($file_error, $item . "\n\r");
            }
            fclose($file_error);
        }

    }
}
<?php


namespace shop\helpers;


use shop\entities\shop\discount\Discount;

class DiscountHelper
{
    public static function discounts(): array
    {
        // по __NAMESPACE__ получить список классов
        $namespace = Discount::getNamespace();
        $classArr = self::getClasses($namespace);

        $result = [];
        foreach ($classArr as $item) {
            $result[$item] = ($namespace . '\\' . $item)::getName();
        }
        return $result;
    }

    private static function getClasses($namespace): array
    {
        $namespaceRelativePath = str_replace('\\', DIRECTORY_SEPARATOR, $namespace);
        $classArr = [];
        $path = dirname(__DIR__, 2) . '\\' . $namespaceRelativePath;
        if (is_dir($path)) {
            $dir = dir($path);
            while (false !== ($item = $dir->read())) {
                $matches = [];
                if (preg_match('/^(.+EnableDiscount)\.php$/', $item, $matches)) {
                    $classArr[] = $matches[1];
                }
            }
            $dir->close();
        }
        return $classArr;
    }
}
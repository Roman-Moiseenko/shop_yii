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
        //var_dump($result);
        return $result;

      /* return [
            CostEnableDiscount::class => CostEnableDiscount::getName(),
            FullTimeEnableDiscount::class => FullTimeEnableDiscount::getName(),
            PeriodYearEnableDiscount::class => PeriodYearEnableDiscount::getName(),
            PeriodMonthEnableDiscount::class => PeriodMonthEnableDiscount::getName(),
            PeriodWeekEnableDiscount::class => PeriodWeekEnableDiscount::getName(),
        ];*/
    }

    private static function getClasses($namespace): array
    {
        $namespaceRelativePath = str_replace('\\', DIRECTORY_SEPARATOR, $namespace); // Include paths
        $classArr = [];
        $path = dirname(__DIR__, 2) . '\\' . $namespaceRelativePath;
        if (is_dir($path)) { // Does path exist?
            $dir = dir($path); // Dir handle
            while (false !== ($item = $dir->read())) {
                // Read next item in dir
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
<?php


namespace shop\services\manage;


use shop\entities\shop\Category;
use shop\entities\shop\Hidden;
use shop\forms\manage\shop\CategoryForm;
use shop\repositories\HiddenRepository;
use shop\repositories\shop\BrandRepository;
use shop\repositories\shop\CategoryRepository;
use shop\repositories\shop\ProductRepository;
use shop\repositories\shop\TagRepository;
use shop\services\TransactionManager;

class LoaderManageService
{

    /**
     * @var ProductRepository
     */
    private $products;
    /**
     * @var BrandRepository
     */
    private $brands;
    /**
     * @var CategoryRepository
     */
    private $categories;
    /**
     * @var TagRepository
     */
    private $tags;
    /**
     * @var HiddenRepository
     */
    private $hidden;
    /**
     * @var TransactionManager
     */
    private $transaction;

    public function __construct(
        ProductRepository $products,
        BrandRepository $brands,
        CategoryRepository $categories,
        TagRepository $tags,
        HiddenRepository $hidden,
        TransactionManager $transaction
    )
    {
        $this->products = $products;
        $this->brands = $brands;
        $this->categories = $categories;
        $this->tags = $tags;
        $this->hidden = $hidden;
        $this->transaction = $transaction;
    }

    private function readLineFromFile($FullFileName)
    {
        $file = fopen($FullFileName, 'rt');
        if (!$file) throw new \Exception();
        while ($row = fgets($file)) {
            yield $row;
        }
        fclose($file);
    }

    public function loadFromFile($file)
    {
        echo '<pre>';
        $path = dirname(__DIR__, 3) . '/static';
        foreach ($this->readLineFromFile($path . $file) as $row) {

            $array_row = (array)json_decode($row);

            print_r($array_row);

        }
        exit();
    }

    private function toHidden(Category $category)
    {
        //TODO 3
    }

    public function loadCategory($file)
    {
        $errors = [];
        $path = dirname(__DIR__, 3) . '/static';
        foreach ($this->readLineFromFile($path . $file) as $row) {
            $array_row = (array)json_decode($row);
            //$form = new CategoryForm();
            $code1C = $array_row['code1C'];
            $name = $array_row['name'];
            $code1C_parent = $array_row['code1C_parent'];
            $parentId = 1;

            /** В отдельную функцию */
            if ($category = $this->categories->getByCode1C($code1C)) { //Категория есть в базе
                if (!empty($code1C_parent)){ //Не родительская категория
                    if ($category_parent = $this->categories->getByCode1C($code1C_parent)) {//Есть родительская
                       // $category->name = $name; //Меняем имя
                        $parentId = $category_parent->id; //Меняем родителя
                    } else {
                        if ($this->hidden->isFind($code1C_parent)) { //Родительская в скрытых
                            $this->toHidden($category);
                            continue;
                        } else {
                            $errors[] = $array_row; //Ошибочная строка, ни где не найдена
                            continue;
                        }
                    }
                } else { //Родительская категория
                    if (substr($name, 0, 1) != '+') { //Перемещена в скрытые
                        $this->toHidden($category);
                        continue;
                    } else {
                        $name = str_replace('+', '', $name);
                        //$category->name = $name; //Меняем имя
                        $parentId = 1; //Родитель root
                    }
                }
                $this->updateCategory($category->id, $name, $parentId);
            } else {
                if ($this->hidden->isFind($code1C)) {
                    continue; //Нашлась в скрытых
                }
                if (!empty($code1C_parent)) { //Не родительская категория
                    if ($this->hidden->isFind($code1C_parent)) { //Родительская в скрытых
                        $hidden = Hidden::create($code1C);
                        $this->hidden->save($hidden);
                        continue; //Нашлась в скрытых
                    }

                    if ($category_parent = $this->categories->getByCode1C($code1C_parent)) {//Есть родительская
                        $parentId = $category_parent->id;

                    } else {
                        $errors[] = $array_row; //Ошибочная строка, ни где не найдена
                        continue;
                    }
                } else { //Родительская категория
                    if (substr($name, 0, 1) != '+') { //Перемещена в скрытые
                        $hidden = Hidden::create($code1C);
                        $this->hidden->save($hidden);
                        continue;
                    } else {
                        $name = str_replace('+', '', $name);
                        $parentId = 1; //Родитель root
                    }
                }
            }
            $this->createCategory($name, $parentId, $code1C);
        }
        if (!empty($errors)) {
            throw new \DomainException('Не все записалось');
        }
    }

    private function updateCategory(int $id, string $name, int $parentId)
    {
        //TODO 1

    }

    private function createCategory(string $name, int $parentId, $code1C)
    {
        //TODO 2
    }

}
<?php


namespace shop\services\manage;


use shop\entities\Meta;
use shop\entities\shop\Category;
use shop\entities\shop\Hidden;
use shop\entities\shop\product\Product;
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



    /** Точка входа для загрузки каталога */
    public function loadCategory($file)
    {
        $path = dirname(__DIR__, 3) . '/static/data/';
        $result = $this->processLoadCategory($path . $file);
        $countErrors = count($result);
        while ($countErrors > 0) {
            $fileError = $this->saveToFile($path, $result);
            $result = $this->processLoadCategory($fileError);

            $countNew = count($result);
            if ($countNew >= $countErrors) {
                throw new \DomainException('Ошибка данных');
            }
            unlink($fileError);
            $countErrors = $countNew;
        }
        unlink($path . $file);
        return true;
    }
    private function readLineFromFile($FullFileName)
    {
        $file = fopen($FullFileName, 'rt');
        if (!$file) {
            throw new \Exception();
        }
        while ($row = fgets($file)) {
            yield $row;
        }
        fclose($file);
    }
    /** Сохраняем не попавшие в базу результат проверки в файл, для повторной обработки*/
    private function saveToFile($path, array $data): string
    {
        $filename = $path . 'errors.load';
        $fp = fopen($filename, 'w');
        foreach ($data as $item) {
            fwrite($fp, json_encode($item) . "\n");
        }
        fclose($fp);
        return $filename;
    }
    /** Процесс загрузки категории в базу */
    private function processLoadCategory($file): array
    {
        $errors = [];
        foreach ($this->readLineFromFile( $file) as $row) {
            $data = (array)json_decode($row);
            if ($this->isEmpty($data)) continue;
            /** В отдельную функцию */
            if ($category = $this->categories->getByCode1C($data['code1C'])) { //Категория есть в базе
                if ($category_parent = $this->categories->getByCode1C($data['code1C_parent'])) {//Родительская в базе
                    //Меняем имя и родителя
                    $this->updateCategory($category->id, $data['name'], $category_parent->id);
                    continue;
                }
                if ($this->hidden->isFind($data['code1C_parent'])) { //Родительская в скрытых
                    $this->toHidden($category);
                    continue;
                }
                $errors[] = $data;
            }

            if ($this->hidden->isFind($data['code1C'])) { //Категория в скрытых сейчас
                if ($category_parent = $this->categories->getByCode1C($data['code1C_parent'])) {//Родительская в базе
                    //была в скрытых, удалить из Hidden
                    $this->hidden->remove($data['code1C']);
                    $this->createCategory($data['name'], $category_parent->id, $data['code1C']);
                    continue;
                }
                if ($this->hidden->isFind($data['code1C_parent'])) { //Родительская в скрытых
                    continue;
                }
                //Сохраняем родительскую в скрытых
                $hidden = Hidden::create($data['code1C_parent']);
                $this->hidden->save($hidden);
            }
            if ($category_parent = $this->categories->getByCode1C($data['code1C_parent'])) {//Родительская в базе
                $this->createCategory($data['name'], $category_parent->id, $data['code1C']);
                continue;
            }
            if ($this->hidden->isFind($data['code1C_parent'])) { //Родительская в скрытых
                //Тоже добавляем в скрытые
                $hidden = Hidden::create($data['code1C']);
                $this->hidden->save($hidden);
                continue;
            }
            //Родительская не найдена
            $errors[] = $data;
        }
        return $errors;
    }
    private function isEmpty(array $data): bool
    {
        if (!empty($data['code1C_parent'])) return false;
        if (substr($data['name'], 0, 1) == '+') { //Перемещена в общие
            $name = str_replace('+', '', $data['name']);
            if ($category = $this->categories->getByCode1C($data['code1C'])) { //Был в каталоге
                //Поменялось только имя
                $this->updateCategory($category->id, $name, 1);
                return true;
            }
            if ($this->hidden->isFind($data['code1C'])) { //была в скрытых, удалить из Hidden
                $this->hidden->remove($data['code1C']);
            }
            //Создать в категории
            $this->createCategory($name, 1, $data['code1C']);
        } else { //Перемещена в скрытые
            if ($category = $this->categories->getByCode1C($data['code1C'])) {
                // была в общих, все подкатегории и товары перенести в скрытые
                $this->toHidden($category);
                return true;
            }
            if (!$this->hidden->isFind($data['code1C'])) {
                //Еще нигде не было
                $hidden = Hidden::create($data['code1C']);
                $this->hidden->save($hidden);
            }
        }
        return true;
    }
    private function updateCategory(int $id, string $name, int $parentId)
    {
        $category = $this->categories->get($id);
        $category->edit(
            $name,
            $category->slug,
            $category->title,
            $category->description,
            new Meta(
                $category->meta->title,
                $category->meta->description,
                $category->meta->keywords
            ),
            $category->code1C
        );
        if ($parentId !== $category->parent->id) {
            $parent = $this->categories->get($parentId);
            $category->appendTo($parent);
        }
        $this->categories->save($category);
    }
    private function createCategory(string $name, int $parentId, $code1C)
    {
        $parent = $this->categories->get($parentId);
        $category = Category::create(
            $name,
            '',
            '', //title
            '', //description
            new Meta($name, $name, $name),
            $code1C);
        $category->appendTo($parent);
        $category->slug = $this->checkSlug($category, $parentId);
        $this->categories->save($category);
    }
    private function toHidden(Category $_category)
    {
        //var_dump($_category);
        /** Скрыть все вложенные категории */
        $categories = Category::find()
            ->andWhere(['>', 'lft', $_category->lft])
            ->andWhere(['<', 'rgt', $_category->rgt])
            ->andWhere(['depth' => $_category->depth + 1])
            ->orderBy('rgt')
            ->all();
        /** @var Category $category */
        //Удаляем все вложенные категории
        foreach ($categories as $category) {
            $this->productsToHiddenByCategory($category->id); //Скрыть все продукты из этих категорий
            $hidden = Hidden::create($category->code1C);
            $this->hidden->save($hidden);
            $this->categories->remove($category);
        }
        //Удаляем саму категорию
        $hidden = Hidden::create($_category->code1C);
        $this->hidden->save($hidden);
        $this->categories->remove($_category);
    }
    private function productsToHiddenByCategory($category_id)
    {
        if (!$products = Product::find()->andWhere(['category_id' => $category_id])->asArray()->all()) return false;
        var_dump($products); exit();
        /** @var Product $product */
        foreach ($products as $product) {
            $hidden = Hidden::create($product->code1C);
            $this->hidden->save($hidden);
            $this->products->remove($product);
        }
    }
    private function checkSlug(Category $category, $parentId)
    {
        if (Category::findOne(['slug' => $category->slug])) {
            $parent = $this->categories->get($parentId);
            return $category->slug . '_' . $parent->slug;
        }
        return $category->slug;
    }

}
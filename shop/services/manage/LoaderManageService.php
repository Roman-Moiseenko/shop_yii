<?php


namespace shop\services\manage;


use shop\entities\Meta;
use shop\entities\shop\Brand;
use shop\entities\shop\Category;
use shop\entities\shop\Characteristic;
use shop\entities\shop\Hidden;
use shop\entities\shop\product\Photo;
use shop\entities\shop\product\Product;
use shop\entities\shop\RegAttribute;
use shop\repositories\HiddenRepository;
use shop\repositories\shop\BrandRepository;
use shop\repositories\shop\CategoryRepository;
use shop\repositories\shop\ProductRepository;
use shop\repositories\shop\TagRepository;
use shop\services\TransactionManager;
use yii\db\Exception;

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


    /** Точка входа для загрузки Каталога */
    public function loadCategory($file)
    {
        $path = dirname(__DIR__, 3) . '/static/data/';
        $result = $this->processLoadCategory($path . $file);
        $countErrors = count($result);
        while ($countErrors > 0) {
            $fileError = $this->saveToFile($path, $result, 'catalog_');
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
    private function saveToFile($path, array $data, $prefix = ''): string
    {
        $filename = $path . $prefix . 'errors.load';
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
        foreach ($this->readLineFromFile($file) as $row) {
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
        $transaction = \Yii::$app->db->beginTransaction();
        try {
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
            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            \Yii::$app->errorHandler->logException($e);
        }

    }

    private function productsToHiddenByCategory($category_id)
    {
        if (!$products = Product::find()->andWhere(['category_id' => $category_id])->asArray()->all()) return false;
        /** @var Product $product */
        foreach ($products as $product) {
            $this->hideProduct($product);
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

    /** Точка входа для загрузки Товаров */
    public function loadProducts(string $file)
    {
        set_time_limit(0);
        ini_set('memory_limit', '2000M');
        $path = dirname(__DIR__, 3) . '/static/data/';
        $result = $this->processLoadProducts($path . $file);
        $countErrors = count($result);
        if ($countErrors != 0) {
            $fileError = $this->saveToFile($path, $result, 'product_');
            throw new \DomainException('Ошибка данных');
        }
        unlink($path . $file);
        return true;
    }

    private function processLoadProducts($file)
    {
        $errors = [];
        foreach ($this->readLineFromFile($file) as $row) {
            $data = (array)json_decode($row);
            if ($product = $this->products->getByCode1C($data['code1C'])) {
                //Товар есть в базе
                if ($category = $this->categories->getByCode1C($data['code1C_parent'])) {
                    //Категория есть
                    $this->updateProduct($product, $category->id, $data);
                    continue;
                }
                if ($this->hidden->isFind($data['code1C_parent'])) {
                    //Категория скрыта => пропускаем товар
                    $this->hideProduct($product);
                    continue;
                }
                $errors[] = $data;
                $this->hideProduct($product);
            } else {
                //Товара нет в базе
                if ($category = $this->categories->getByCode1C($data['code1C_parent'])) {
                    //Создаем товар,
                    $this->createProduct($data, $category->id);
                    continue;
                }
                if ($this->hidden->isFind($data['code1C_parent'])) {
                    //Категория скрыта => пропускаем товар
                    continue;
                }
                $errors[] = $data['code1C_parent'];
                $errors[] = $data;
            }
        }
        return $errors;
    }

    private function createProduct(array $data, int $id)
    {
        //Загрузка основных данных
        $product = Product::create(
            $this->getBrandFromName($data['name']),
            $id,
            '',
            $data['name'],
            $data['descr'],
            $data['code1C'],
            new Meta(
                $data['name'],
                $data['name'],
                ''
            ),
            $data['unit'],
            $data['remains']
        );
        $product->updatePrice($data['price'], 0);
        $idImage = $data['id'];
        $path = dirname(__DIR__, 3) . '/static/products/';
        if (!file_exists($filePhoto = $path . $idImage .'.jpg')) {
            $filePhoto = $path . 'no-image.jpg';
        }
        $this->products->save($product);

        ///Загрузка фотографий
        $idProduct = $product->id;
        $photo = new Photo();
        $photo->file = $filePhoto;
        $photo->product_id = $idProduct;
        $photo->sort = 0;
        $photo->save();
        $photo->file = $photo->id . '.jpg';
        $photo->save();
        $path_product = dirname(__DIR__, 3) . '/static/origin/products/' . $idProduct . '/';
        mkdir($path_product);
        copy($filePhoto, $path_product . $photo->id . '.jpg');

        $product->addPhotoClass($photo);// mainPhoto = $photo->id;
        $this->products->save($product);
        $this->regProduct($product);
        
        unset($photo);
        unset($product);
    }

    private function updateProduct(Product $product, int $id, array $data)
    {
        if ($product->name !== $data['name']) {
            $product->name = $data['name'];
            $this->regProduct($product);
        }
        if ($product->code1C !== $data['code1C']) $product->code1C = $data['code1C'];
        if ($product->units !== $data['unit']) $product->units = $data['unit'];

        $product->setRemains($data['remains']);

        $price_old = ($product->price_new > (float)$data['price']) ? $product->price_new : 0;
        $product->updatePrice($data['price'], $price_old);

        $this->products->save($product);
    }

    private function regProduct(Product $product): void
    {

        //TODO Переделать под ООП, см.ответ с форума
        /** Низкоуровневый запрос */
       $sql =   'SELECT r.* FROM ' . RegAttribute::tableName() . ' AS r ' .
                'LEFT JOIN ' . Category::tableName() .' c ON c.id=r.category_id WHERE ' .
                'c.lft <= (SELECT lft FROM ' . Category::tableName() .' WHERE id=(SELECT category_id FROM ' . Product::tableName() . ' WHERE id = ' . $product->id .')) ' .
                ' AND '.
                'c.rgt >= (SELECT rgt FROM ' . Category::tableName() .' WHERE id=(SELECT category_id FROM ' . Product::tableName() . ' WHERE id = ' . $product->id .'))';

        try {
            $results = \Yii::$app->db->createCommand($sql)->queryAll();

            foreach ($results as $result) {
                $reg = RegAttribute::create($result['category_id'], $result['reg_match'], $result['characteristic_id']);
                $this->pregMatchAttribute($product, $reg);
            }
        } catch (Exception $e) {
            \Yii::$app->errorHandler->logException($e);
        }
    }

    private function getBrandFromName($name):? int
    {
        /** @var Brand[] $brands */
        $brands = Brand::find()->all();
        foreach ($brands as $brand) {
            if (mb_stripos($name, $brand->name, 0, 'UTF-8') !== false) return $brand->id;
        }
        $brand = Brand::findOne(['name' => 'NONAME']);
        return $brand->id ?? null; //NONAME
    }

    public function updateBrand()
    {

        $brands = Brand::find()->andWhere(['<>', 'name', 'NONAME'])->all();
        $idNoName = Brand::findOne(['name' => 'NONAME']);
        foreach ($brands as $brand) {
            $products = Product::find()->select('id')->active()
                ->andWhere(['brand_id' => $idNoName])
                ->andWhere(['LIKE', 'name', $brand->name])
                ->column();
            Product::updateAll(['brand_id' => $brand->id], ['id' => $products]);
        }
    }

    private function hideProduct(Product $product)
    {
        $product->changeMainCategory(1);
        $product->draft();
        $this->products->save($product);
    }

    public function updateAttributes()
    {
        /** @var RegAttribute $regs */
        $regs = RegAttribute::find()->all();
        foreach ($regs as $reg) {
            $categories = Category::find()->select('id')
                ->andWhere(['>=', 'lft', $reg->category->lft])
                ->andWhere(['<=', 'rgt', $reg->category->rgt])
                ->andWhere(['>', 'depth', $reg->category->depth])
                ->asArray()->column();
            $products = Product::find()
                ->andWhere(['category_id' => array_merge([$reg->category_id], $categories)])
                ->all();
            foreach ($products as $product) {
               $this->pregMatchAttribute($product, $reg);
            }
        }
    }

    private function pregMatchAttribute(Product $product, RegAttribute $reg)
    {
        preg_match_all($reg->reg_match, $product->name, $value);
        if ($count = count($value[1]) > 0    ) {
            if ((count($value[1]) > 1) && ($value[1][0] == 3)) {
                $val = 0;
                foreach ($value[1] as $item) {
                    $val += (int)$item;
                }
            } else {
                $val = $value[1][0];
            }
            $characteristic = Characteristic::findOne($reg->characteristic_id);
            if ($characteristic->isSelect()) { //Если тип содержит варианты
                $product->setValue($reg->characteristic_id, $characteristic->getVariant($val));
            } else {
                $product->setValue($reg->characteristic_id, $val);
            }
            $this->products->save($product);
        } else {
            $this->LogErrorPregMatch($product, $reg);
        }
    }

    private function LogErrorPregMatch(Product $product, RegAttribute $reg): void
    {
        $filename = dirname(__DIR__, 3) . '/static/data/errors_preg_match.load';
        $fp = fopen($filename, 'a');
        fwrite($fp, $product->id . '.' . $product->name . ' => ' . $reg->reg_match . "\n");
        fclose($fp);
    }

    public function setBrand($category_id, $brand_id)
    {
        $category = Category::findOne(['id' => $category_id]);
        $categories = Category::find()->select('id')
            ->andWhere(['>=', 'lft', $category->lft])
            ->andWhere(['<=', 'rgt', $category->rgt])
            ->andWhere(['>=', 'depth', $category->depth])
            ->asArray()->column();

        $list = implode(',', $categories);
        \Yii::$app->db->createCommand(
            'UPDATE shop_products SET brand_id = ' . $brand_id . ' WHERE category_id IN (' . $list . ')'
        )->execute();

    }
}
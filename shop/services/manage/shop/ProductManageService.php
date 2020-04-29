<?php


namespace shop\services\manage\shop;


use shop\entities\Meta;
use shop\entities\shop\Category;
use shop\entities\shop\product\Product;
use shop\entities\shop\product\TagAssignment;
use shop\entities\shop\Tag;
use shop\forms\manage\shop\product\CategoriesForm;
use shop\forms\manage\shop\product\ModificationForm;
use shop\forms\manage\shop\product\PhotosForm;
use shop\forms\manage\shop\product\PriceForm;
use shop\forms\manage\shop\product\ProductCreateForm;
use shop\forms\manage\shop\product\ProductEditForm;
use shop\repositories\shop\BrandRepository;
use shop\repositories\shop\CategoryRepository;
use shop\repositories\shop\ProductRepository;
use shop\repositories\shop\TagRepository;
use shop\services\TransactionManager;

class ProductManageService
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
     * @var TransactionManager
     */
    private $transaction;

    public function __construct(
        ProductRepository $products,
        BrandRepository $brands,
        CategoryRepository $categories,
        TagRepository $tags,
        TransactionManager $transaction
)
    {
        $this->products = $products;
        $this->brands = $brands;
        $this->categories = $categories;
        $this->tags = $tags;
        $this->transaction = $transaction;
    }

    public function create(ProductCreateForm $form): Product
    {
        $brand = $this->brands->get($form->brandId);
        $category = $this->categories->get($form->categories->main);
        $product = Product::create(
            $brand->id,
            $category->id,
            $form->code,
            $form->name,
            $form->description,
            $form->code1C,
            new Meta(
                $form->meta->title,
                $form->meta->description,
                $form->meta->keywords
            )
        );

        $product->updatePrice($form->price->new, $form->price->old);
        foreach ($form->categories->others as $otherId) {
            $category = $this->categories->get($otherId);
            $product->assignCategory($category->id);
        }
        foreach ($form->values as $value) {
            $product->setValue($value->id, $value->value);
        }

        if ($form->photos->files != null)
        foreach ($form->photos->files as $file) {
            $product->addPhoto($file);
        }

        foreach ($form->tags->existing as $tagId) {
            $tag = $this->tags->get($tagId);
            $product->assignTag($tag->id);
        }

        $this->transaction->wrap(function () use ($form, $product) {
            foreach ($form->tags->newNames as $tagName) {
                if (!$tag = $this->tags->findByName($tagName)) {
                    $tag = Tag::create($tagName, $tagName);
                    $this->tags->save($tag);
                }
                $product->assignTag($tag->id);
            }
            $this->products->save($product);
        });
        return $product;
    }

    public function edit($id, ProductEditForm $form): void
    {
        $product = $this->products->get($id);
        $brand = $this->brands->get($id);
        $category = $this->categories->get($form->categories->main);
        $product->edit(
            $brand->id,
            $form->code,
            $form->name,
            $form->description,
            $form->code1C,
            new Meta(
                $form->meta->title,
                $form->meta->description,
                $form->meta->keywords
            )
        );

        $product->changeMainCategory($category->id);
        $product->revokeCategories();

        foreach ($form->categories->others as $otherId) {
            $category = $this->categories->get($otherId);
            $product->assignCategory($category->id);
        }

        foreach ($form->values as $value) {
            $product->setValue($value->id, $value->value);
        }

        $product->revokeTags();
        foreach ($form->tags->existing as $tagId) {
            $tag = $this->tags->get($tagId);
            $product->assignTag($tag->id);
        }

        $this->transaction->wrap(function () use ($form, $product) {
            foreach ($form->tags->newNames as $tagName) {
                if (!$tag = $this->tags->findByName($tagName)) {
                    $tag = Tag::create($tagName, $tagName);
                    $this->tags->save($tag);
                }
                $product->assignTag($tag->id);
            }

            $this->products->save($product);
        });

    }

    public function changeCategories($id, CategoriesForm $form): void
    {
        $product = $this->products->get($id);
        $category = $this->categories->get($form->main);
        $product->changeMainCategory($category->id);
        $product->revokeCategories();
        foreach ($form->others as $otherId) {
            $category = $this->categories->get($otherId);
            $product->assignCategory($category->id);
        }
        $this->products->save($product);
    }

    public function changePrice($id, PriceForm $form): void
    {
        $product = $this->products->get($id);
        $product->price_new = $form->new;
        $product->price_old = $form->old;
        $this->products->save($product);
    }
    public function addPhotos($id, PhotosForm $form): void
    {
        $product = $this->products->get($id);
        foreach ($form->files as $file) {
            $product->addPhoto($file);
        }
        $this->products->save($product);
    }

    public function movePhotoUp($id, $photoId): void
    {
        $product = $this->products->get($id);
        $product->movePhotoUp($photoId);
        $this->products->save($product);
    }

    public function movePhotoDown($id, $photoId): void
    {
        $product = $this->products->get($id);
        $product->movePhotoDown($photoId);
        $this->products->save($product);
    }

    public function removePhoto($id, $photoId): void
    {
        $product = $this->products->get($id);
        $product->removePhoto($photoId);
        $this->products->save($product);
    }

    public function remove($id): void
    {
        $categories = $this->categories->get($id);
        $this->categories->remove($categories);
    }
    public function activate($id): void
    {
        $product = $this->products->get($id);
        $product->activate();
        $this->products->save($product);
    }

    public function draft($id): void
    {
        $product = $this->products->get($id);
        $product->draft();
        $this->products->save($product);
    }

    public function addModification(int $id, ModificationForm $form)
    {
        $product = $this->products->get($id);
        $product->addModification($form->code, $form->name, $form->price);
        $this->products->save($product);
    }

    public function editModification(int $id, int $id_modification, ModificationForm $form)
    {
        $product = $this->products->get($id);
        $product->editModification($id_modification, $form->code, $form->name, $form->price);
        $this->products->save($product);
    }

    public function removeModification($id, ModificationForm $form)
    {

    }
}
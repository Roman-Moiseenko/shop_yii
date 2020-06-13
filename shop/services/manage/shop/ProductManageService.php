<?php


namespace shop\services\manage\shop;


use shop\entities\Meta;
use shop\entities\shop\product\Product;
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
use shop\repositories\shop\ReviewRepository;
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
    /**
     * @var ReviewRepository
     */
    private $reviews;

    public function __construct(
        ProductRepository $products,
        BrandRepository $brands,
        CategoryRepository $categories,
        TagRepository $tags,
        TransactionManager $transaction,
        ReviewRepository $reviews
)
    {
        $this->products = $products;
        $this->brands = $brands;
        $this->categories = $categories;
        $this->tags = $tags;
        $this->transaction = $transaction;
        $this->reviews = $reviews;
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
            ),
            $form->units
        );
        $this->transaction->wrap(function () use ($form, $product) {
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
        $brand = $this->brands->get($form->brandId);
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
            ),
            $form->units
        );

        $product->changeMainCategory($category->id);

        $this->transaction->wrap(function () use ($product, $form) {

            $product->revokeCategories();
            $product->revokeTags();
            $this->products->save($product);

            foreach ($form->categories->others as $otherId) {
                $category = $this->categories->get($otherId);
                $product->assignCategory($category->id);
            }

            foreach ($form->values as $value) {
                $product->setValue($value->id, $value->value);
            }

            foreach ($form->tags->existing as $tagId) {
                $tag = $this->tags->get($tagId);
                $product->assignTag($tag->id);
            }
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

    public function changeFeatured($id, $featured)
    {
        $product = $this->products->get($id);
        if ($featured) {
            $product->addFeatured();
        } else {
            $product->removeFeatured();
        }
        $this->products->save($product);
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
        $product = $this->products->get($id);
        $this->products->remove($product);
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

    public function removeModification($id, $modificationId)
    {
        $product = $this->products->get($id);
        $product->removeModification($modificationId);
        $this->products->save($product);
    }

    public function setRemains($id, $remains)
    {
        $product = $this->products->get($id);
        $product->setRemains($remains);
        $this->products->save($product);
    }

    public function addReview($id, $userId, $vote, $text)
    {
        $product = $this->products->get($id);
        $product->addReview($userId, $vote, $text);
        $this->products->save($product);
    }

    public function activateReview($reviewId)
    {
        $review = $this->reviews->get($reviewId);
        $product = $this->products->get($review->product_id);
        $product->activateReview($reviewId);
        $this->products->save($product);
    }

    public function draftReview($reviewId)
    {
        $review = $this->reviews->get($reviewId);
        $product = $this->products->get($review->product_id);
        $product->draftReview($reviewId);
        $this->products->save($product);
    }

    public function removeReview($reviewId)
    {
        $review = $this->reviews->get($reviewId);
        $product = $this->products->get($review->product_id);
        $product->removeReview($reviewId);
        $this->products->save($product);
    }
}
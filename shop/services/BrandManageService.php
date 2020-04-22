<?php


namespace shop\services;


use shop\entities\Meta;
use shop\entities\shop\Brand;
use shop\forms\manage\MetaForm;
use shop\forms\manage\shop\BrandForm;
use shop\repositories\shop\BrandRepository;

class BrandManageService
{
    private $brands;

    public function __construct(BrandRepository $brands)
    {

        $this->brands = $brands;
    }

    public function create(BrandForm $form, MetaForm $metaForm):Brand
    {
        $brand = Brand::create(
            $form->name,
            $form->slug,
            new Meta(
                $metaForm->title,
                $metaForm->description,
                $metaForm->keywords
            ));
        $this->brands->save($brand);
        return $brand;

    }

    public function edit($id, BrandForm $form)
    {
        $brand = $this->brands->get($id);
        $brand->edit(
            $form->name,
            $form->slug,
            new Meta(
                $form->meta->title,
                $form->meta->description,
                $form->meta->keywords
            )
        );
        $this->brands->save($brand);
    }

    public function remove($id)
    {
        $brand = $this->brands->get($id);
        $this->brands->remove($brand);
    }

}
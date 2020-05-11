<?php


namespace shop\services\manage;


use shop\entities\shop\RegAttribute;
use shop\forms\data\RegAttributeForm;
use shop\repositories\RegAttributeRepository;
use shop\repositories\shop\CategoryRepository;
use shop\repositories\shop\CharacteristicRepository;

class RegAttributeManageService
{

    /**
     * @var RegAttributeRepository
     */
    private $regAttributes;

    public function __construct(RegAttributeRepository $regAttributes)
    {
        $this->regAttributes = $regAttributes;
    }

    public function create(RegAttributeForm $form): RegAttribute
    {
        $reg = RegAttribute::create(
            $form->category_id,
            $form->reg_match,
            $form->characteristic_id
        );
        $this->regAttributes->save($reg);
        return $reg;

    }

    public function edit($id, RegAttributeForm $form): void
    {
        $reg = $this->regAttributes->get($id);
        $reg->category_id = $form->category_id;
        $reg->reg_match = $form->reg_match;
        $reg->characteristic_id = $form->characteristic_id;
        $this->regAttributes->save($reg);
    }

    public function remove($id): void
    {
        $reg = $this->regAttributes->get($id);
        $this->regAttributes->remove($reg);
    }


}
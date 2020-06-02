<?php


namespace shop\services\manage;


use shop\entities\Params;
use shop\forms\data\ParamsForm;
use shop\repositories\shop\ParamsRepository;

class ParamsManageService
{

    /**
     * @var ParamsRepository
     */
    private $params;

    public function __construct(ParamsRepository $params)
    {
        $this->params = $params;
    }

    public function create(ParamsForm $form): Params
    {
        //$key, $value
        $params = Params::create($form->key, $form->value, $form->description);
        $this->params->save($params);
        return $params;
    }

    public function edit(ParamsForm $form): void
    {
        $params = $this->params->get($form->key);
        $params->edit($form->value, $form->description);
        $this->params->save($params);
    }

    public function remove($key): void
    {
        $params = $this->params->get($key);
        $this->params->remove($params);
    }
}
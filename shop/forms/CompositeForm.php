<?php


namespace shop\forms;


use yii\base\Model;
use yii\helpers\ArrayHelper;

abstract class  CompositeForm extends Model
{
    private $forms = [];

    abstract protected function internalForms(): array;
    public function load($data, $formName = null)
    {
        $success = parent::load($data, $formName);
        $success2 = $success;
        foreach ($this->forms as $name => $form) {

            if (is_array($form)) {
                $success2 = Model::loadMultiple($form, $data, $formName === null  ? null : $name);
                $success =  $success2 && $success;
            } else {
                $success2 = $form->load($data, $formName !== '' ? null : $name);
                $success =  $success2 && $success;
            }
        }
        return $success;
    }

    public function validate($attributeNames = null, $clearErrors = true)
    {
        $parentNames = $attributeNames !== null ? array_filter((array)$attributeNames, 'is_string') : null;
        $success = parent::validate($parentNames, $clearErrors);
        $success2 = $success;
        foreach ($this->forms as $name => $form) {
            if (is_array($form)) {
                $success2 = Model::validateMultiple($form);
                $success = $success2    && $success;
            } else {
                $innerNames = $attributeNames !== null ? ArrayHelper::getValue($attributeNames, $name) : null;
                $success2 = $form->validate($innerNames ?: null, $clearErrors);
                $success = $success2 && $success;
            }
        }
        return $success;
    }
    public function __get($name)
    {
        if (isset($this->forms[$name])) {
            return $this->forms[$name];
        }
        return parent::__get($name);
    }

    public function __set($name, $value)
    {
        if (in_array($name, $this->internalForms(), true)) {
            $this->forms[$name] = $value;
        } else {
            parent::__set($name, $value);
        }
    }

    public function __isset($name)
    {
        return isset($this->forms[$name]) || parent::__isset($name);
    }

}
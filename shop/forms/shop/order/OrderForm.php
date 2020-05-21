<?php


namespace shop\forms\shop\order;


use shop\forms\CompositeForm;

/**
 * @property DeliveryForm $delivery
 * @property CustomerForm $customer
 */

class OrderForm extends CompositeForm
{
    public $note;

    public function __construct($amount, $config = [])
    {
        $this->delivery = new DeliveryForm($amount);
        $this->customer = new CustomerForm();
        parent::__construct($config);
    }

    public function rules()
    {
        return [['note'], 'string'];
    }

    protected function internalForms(): array
    {
        return ['delivery', 'customer'];
    }
}
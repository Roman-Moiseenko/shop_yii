<?php


namespace shop\cart\storage;


use yii\web\Session;

class SessionStorage implements StorageInterface
{
    private $key = 'cart';
   // private $session;

    public function __construct($key/*, Session $session*/)
    {
        $this->key = $key;
       // $this->session = $session;
    }
    public function load(): array
    {
        return \Yii::$app->session->get($this->key, []);
    }

    public function save(array $items): void
    {
        \Yii::$app->session->set($this->key, $items);
    }
}
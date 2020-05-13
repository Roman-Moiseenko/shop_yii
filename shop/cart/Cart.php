<?php


namespace shop\cart;


use shop\entities\shop\product\Product;

class Cart
{
    private $items;

    public function getItems(): array
    {

    }

    public function add(Product $product, $modificationId, $quantity)
    {
        $items = $this->loadItems();
        $id = md5(serialize([$product->id, $modificationId]));
        foreach ($items as $i => $item) {
            if ($item['id'] == $id) {
                $items[$i]['quantity'] += $quantity;
                $this->saveItems($items);
                return;
            }
        }
        $items[] = [
            'id' => $id,
            'product' => $product,
            'modification' => $modificationId,
            'quantity' => $quantity,
        ];
        $this->saveItems($items);
    }
    public function remove($id): void
    {
        $items = $this->loadItems();
        foreach ($items as $i => $item) {
            if ($item['id'] == $id) {
                unset($items[$i]);
                $this->saveItems($items);
                return;
            }
        }
    }


    private function loadItems(): array
    {
        if ($this->items === null) {
            return \Yii::$app->session->get('cart', []);
        }
        return $this->items;
    }

    private function saveItems($items): void
    {
        $this->items = $items;
        \Yii::$app->session->set('cart', $items);
    }
}
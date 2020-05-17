<?php

namespace shop\cart;

use shop\cart\cost\calculator\CalculatorInterface;
use shop\cart\cost\Cost;
use shop\cart\storage\StorageInterface;

class Cart
{
    /** @var CartItem[] */
    private $items;
    /**
     * @var StorageInterface
     */
    private $storage;
    private $calculator;

    public function __construct(StorageInterface $storage, CalculatorInterface $calculator)
    {
        $this->storage = $storage;
        $this->calculator = $calculator;
    }

    /** @return CartItem[] */
    public function getItems(): array
    {
        $this->loadItems();
        return $this->items;
    }

    public function getAmount(): int
    {
        $this->loadItems();
        return count($this->items);
    }

    public function getCost(): Cost
    {
        $this->loadItems();
        return $this->calculator->getCoast($this->items);
    }

    public function add(CartItem $item)
    {
        $this->loadItems();
        foreach ($this->items as $i => $current) {
            if ($current->getId() == $item->getId()) {
                $this->items[$i] = $current->plus($item->getQuantity());
                $this->saveItems();
                return;
            }
        }
        $this->items[] = $item;
        $this->saveItems();
    }

    public function set($id, $quantity)
    {
        $this->loadItems();
        foreach ($this->items as $i => $current) {
            if ($current->getId() == $id) {
                $this->items[$i] = $current->set($quantity);
                $this->saveItems();
                return;
            }
        }
        throw new \DomainException('Элемент не найден');
    }

    public function sub(CartItem $item)
    {
        $this->loadItems();
        foreach ($this->items as $i => $current) {
            if ($current->getId() == $item->getId()) {
                //Проверить если null, удаляется ли элемент
                $this->items[$i] = $current->sub($item->getQuantity());
                $this->saveItems();
                return;
            }
        }
        throw new \DomainException('Элемент не найден');
    }

    public function remove($id): void
    {
        $this->loadItems();
        foreach ($this->items as $i => $current) {
            if ($current->getId() == $id) {
                unset($this->items[$i]);
                $this->saveItems();
                return;
            }
        }
    }

    private function loadItems(): void
    {
        if ($this->items === null) {
            $this->items = $this->storage->load();
        }
    }

    private function saveItems(): void
    {
        $this->storage->save($this->items);
    }

    public function clear()
    {
        $this->items = [];
        $this->saveItems();
    }
}
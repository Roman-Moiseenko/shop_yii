<?php


namespace shop\cart\storage;


interface StorageInterface
{
    public function load(): array;
    public function save(array $items): void;
}
<?php

namespace Filo\ShoppingCart\Domain;

class ShoppingCart
{
    private array $items = [];

    public function __construct(ItemShoppingCart  ...$items)
    {
        $this->items = $items;
    }
    public function addItem(ItemShoppingCart $item)
    {
        $this->items[$item->id()] = $item;
    }
    public static function create(ItemShoppingCart  $items): self
    {
        return new self($items);
    }
    public function items()
    {
        return $this->items;
    }
    public function calculateTotal(): float
    {
        $sum = 0;
        foreach ($this->items as $item) {
            $sum += $item->price() * $item->quantity();
        }
        return $sum;
    }
}

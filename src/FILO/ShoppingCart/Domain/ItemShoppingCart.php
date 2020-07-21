<?php

namespace Filo\ShoppingCart\Domain;


class ItemShoppingCart
{
    private string $id;
    private float $price;
    private int $quantity;
    public function __construct(string $id, float $price, int $quantity)
    {
        $this->id = $id;
        $this->price = $price;
        $this->quantity = $quantity;
    }
    public function quantity(): int
    {
        return $this->quantity;
    }
    public function discount(): float
    {
        return 0;
    }

    public function id()
    {
        return $this->id;
    }
    public function price()
    {
        return $this->price;
    }
}

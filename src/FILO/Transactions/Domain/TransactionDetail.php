<?php

namespace Filo\Transactions\Domain;

use Filo\Menus\Domain\Menu;
use Filo\Menus\Domain\MenuId;
use JsonSerializable;
use Serializable;

class TransactionDetail implements JsonSerializable
{
    private string $id;
    private Menu $menu;
    private float $quantity;

    public function __construct(string $id, Menu $menu, float $quantity)
    {
        $this->id = $id;
        $this->menu = $menu;
        $this->quantity = $quantity;
    }
    public function jsonSerialize()
    {
        return [
            "id" => $this->id,
            "quantity" => $this->quantity,
            "product" => [
                "id" => $this->menu->id()->value(),
                "name" => $this->menu->name()->value(),
                "price" => $this->menu->price()->value(),
                "photo" => $this->menu->photo()->value()
            ]
        ];
    }
    public function id(): string
    {
        return $this->id;
    }
    public function menu(): Menu
    {
        return $this->menu;
    }
    public function quantity(): float
    {
        return $this->quantity;
    }
}

<?php

namespace Filo\Transactions\Domain;

use Filo\Menus\Domain\Menu;
use Filo\Menus\Domain\MenuId;

class TransactionDetail
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
    public function id(): string
    {
        return $this->id;
    }
    public function menuId(): MenuId
    {
        return $this->menuId;
    }
    public function quantity(): float
    {
        return $this->quantity;
    }
}

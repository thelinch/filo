<?php

namespace Filo\Transactions\Domain;

use Filo\Menus\Domain\MenuId;

class TransactionDetail
{
    private string $id;
    private MenuId $menuId;
    private float $quality;

    public function __construct(string $id, MenuId $menuId, float $quality)
    {
        $this->id = $id;
        $this->menuId = $menuId;
        $this->quality = $quality;
    }
    public function id(): string
    {
        return $this->id;
    }
    public function menuId(): MenuId
    {
        return $this->menuId;
    }
    public function quality(): float
    {
        return $this->quality;
    }
}

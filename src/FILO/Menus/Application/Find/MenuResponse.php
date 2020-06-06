<?php

namespace Filo\Menus\Application\Find;

use Filo\Menus\Domain\Menu;
use JsonSerializable;
use src\Shared\Domain\Bus\Query\Response;

class MenuResponse implements Response, JsonSerializable
{
    private string $name;
    private int $votes;
    private string $id;
    private float $price;


    public function __construct(Menu $menu)
    {
        $this->id = $menu->id()->value();
        $this->votes = $menu->votes()->value();
        $this->price = $menu->price()->value();
        $this->name = $menu->name()->value();
    }

    public function jsonSerialize()
    {
        return
            [
                'id'   => $this->id,
                'name' => $this->name,
                "votes" => $this->votes,
                "price" => $this->price
            ];
    }
}

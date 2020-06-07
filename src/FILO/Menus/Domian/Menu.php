<?php

namespace Filo\Menus\Domain;

use Filo\Partners\Domain\PartnerId;
use src\Shared\Domain\Aggregate\AggregateRoot;

class Menu extends AggregateRoot
{
    private MenuId $id;
    private PartnerId $partnerId;
    private MenuPrice $price;
    private MenuVotes $votes;
    private MenuName $name;
    public function __construct(MenuId $id, PartnerId $partnerId, MenuPrice $price, MenuVotes $votes, MenuName $name)
    {
        $this->id = $id;
        $this->partnerId = $partnerId;
        $this->price = $price;
        $this->votes = $votes;
        $this->name = $name;
    }
    public static function create(MenuId $id, PartnerId $partnerId, MenuPrice $price, MenuVotes $votes, MenuName $name): self
    {

        $menu = new self($id, $partnerId, $price, $votes, $name);
        $menu->record(new MenuCreateDomainEvent($id->value(),  $name->value(), $partnerId->value()));
        return $menu;
    }
    public function name(): MenuName
    {
        return $this->name;
    }
    public function id(): MenuId
    {
        return $this->id;
    }

    public function partnerId(): PartnerId
    {
        return $this->partnerId;
    }
    public function price(): MenuPrice
    {
        return $this->price;
    }
    public function votes(): MenuVotes
    {
        return $this->votes;
    }
}

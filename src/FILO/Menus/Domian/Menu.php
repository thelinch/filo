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
    private MenuPhoto $photo;
    private MenuDescription $description;
    public function __construct(MenuId $id, PartnerId $partnerId, MenuPrice $price, MenuVotes $votes, MenuName $name, MenuPhoto $photo, MenuDescription $description)
    {
        $this->id = $id;
        $this->partnerId = $partnerId;
        $this->price = $price;
        $this->votes = $votes;
        $this->name = $name;
        $this->photo = $photo;
        $this->description = $description;
    }
    public static function create(MenuId $id, PartnerId $partnerId, MenuPrice $price, MenuVotes $votes, MenuName $name, MenuPhoto $photo, MenuDescription $description): self
    {

        $menu = new self($id, $partnerId, $price, $votes, $name, $photo, $description);
        $menu->record(new MenuCreateDomainEvent($id->value(),  $name->value(), $partnerId->value()));
        return $menu;
    }
    public function deletePhoto()
    {
        $this->photo = $this->photo->delete();
    }
    public function delete()
    {
        $this->record(new MenuDeleteDomainEvent($this->id()->value(), $this->name()->value(), $this->partnerId()->value()));
    }
    public function description(): MenuDescription
    {
        return $this->description;
    }

    public function update(string $newName, string $newPhoto, float $newPrice, string $newDescription)
    {
        $this->photo = $this->photo->update($newPhoto);
        $this->name = $this->name->update($newName);
        $this->description = $this->description->update($newDescription);
        $this->price = $this->price->update($newPrice);
    }
    public function name(): MenuName
    {
        return $this->name;
    }
    public function incrementVotes()
    {

        $this->votes = $this->votes->increment();
    }
    public function photo(): MenuPhoto
    {
        return $this->photo;
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

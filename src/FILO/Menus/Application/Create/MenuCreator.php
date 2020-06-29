<?php

namespace Filo\Menus\Application\Create;

use Filo\Menus\Domain\Menu;
use Filo\Menus\Domain\MenuDescription;
use Filo\Menus\Domain\MenuId;
use Filo\Menus\Domain\MenuName;
use Filo\Menus\Domain\MenuPhoto;
use Filo\Menus\Domain\MenuPrice;
use Filo\Menus\Domain\MenuRepositoryI;
use Filo\Menus\Domain\MenuVotes;
use Filo\Partners\Domain\PartnerId;
use src\Shared\Domain\Bus\Event\EventBus;
use src\Shared\Domain\UuidGenerator;

final class MenuCreator
{
    private MenuRepositoryI $repository;
    private EventBus $bus;
    public function __construct(MenuRepositoryI $repository, EventBus $bus)
    {
        $this->repository = $repository;
        $this->bus = $bus;
    }
    public function __invoke(MenuId $id, MenuName $name, MenuPrice $price, MenuVotes $votes, PartnerId $partnerId, MenuPhoto $photo, MenuDescription $description)
    {

        $menu = Menu::create(
            $id,
            $partnerId,
            $price,
            $votes,
            $name,
            $photo,
            $description
        );
        $this->repository->create($menu);
        $this->bus->publish(...$menu->pullDomainEvents());
    }
}

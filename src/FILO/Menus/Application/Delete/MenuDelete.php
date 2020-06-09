<?php

namespace Filo\Menus\Application\Delete;

use Filo\Menus\Application\Find\MenuFinder;
use Filo\Menus\Domain\MenuId;
use Filo\Menus\Domain\MenuRepositoryI;
use Illuminate\Support\Facades\App;
use src\Shared\Domain\Bus\Event\EventBus;

class MenuDelete
{
    private MenuRepositoryI $repository;
    private MenuFinder $menuFinder;
    private EventBus $bus;
    public function __construct(MenuRepositoryI $repository, EventBus $bus)
    {
        $this->repository = $repository;
        $this->menuFinder = App::make("menuFinder");
        $this->bus = $bus;
    }

    public function __invoke(MenuId $id)
    {
        $menu = $this->menuFinder->__invoke($id);
        $menu->delete();
        $this->repository->delete($menu);
        $this->bus->publish(...$menu->pullDomainEvents());
    }
}

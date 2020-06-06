<?php

namespace Filo\Menus\Application\Update;

use Filo\Menus\Application\Find\MenuFinder;
use Filo\Menus\Domain\MenuId;
use Filo\Menus\Domain\MenuName;
use Filo\Menus\Domain\MenuPrice;
use Filo\Menus\Domain\MenuRepositoryI;
use Illuminate\Support\Facades\App;

class MenuUpdate
{


    private MenuRepositoryI $repository;
    private MenuFinder $menuFinder;
    public function __construct(MenuRepositoryI $repository)
    {
        $this->repository = $repository;
        $this->menuFinder = App::make("menuFinder");
    }

    public function __invoke(MenuId $id, MenuName $newName, MenuPrice $menuPrice)
    {
        $menu = $this->menuFinder->__invoke($id);
        $menu->update($newName, $menuPrice);
        $this->repository->update($menu);
    }
}

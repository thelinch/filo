<?php

namespace Filo\Menus\Application\Delete;

use Filo\Menus\Application\Find\MenuFinder;
use Filo\Menus\Domain\MenuId;
use Filo\Menus\Domain\MenuRepositoryI;
use Illuminate\Support\Facades\App;

class MenuDelete
{
    private MenuRepositoryI $repository;
    private MenuFinder $menuFinder;
    public function __construct(MenuRepositoryI $repository)
    {
        $this->repository = $repository;
        $this->menuFinder = App::make("menuFinder");
    }

    public function __invoke(MenuId $id)
    {
        $menu = $this->menuFinder->__invoke($id);
        $this->repository->delete($menu);
    }
}

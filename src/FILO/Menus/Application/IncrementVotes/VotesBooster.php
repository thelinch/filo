<?php

namespace Filo\Menus\Application\IncrementVotes;

use Filo\Menus\Domain\MenuId;
use Filo\Menus\Domain\MenuRepositoryI;
use Filo\Menus\Domain\Service\MenuFinder;
use Illuminate\Support\Facades\App;

class VotesBooster
{
    private MenuFinder $menuFinder;
    private MenuRepositoryI $repository;
    public function __construct(MenuRepositoryI $repository)
    {
        $this->menuFinder = App::make(MenuFinder::class);
        $this->repository = $repository;
    }
    public function __invoke(MenuId $menuId)
    {
        $menu = $this->menuFinder->__invoke($menuId);
        $menu->incrementVotes();
        $this->repository->updateVotes($menu);
    }
}

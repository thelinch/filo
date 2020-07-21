<?php

namespace Filo\Menus\Application\Find;

use Filo\Menus\Domain\Menu;
use Filo\Menus\Domain\MenuId;
use Filo\Menus\Domain\MenuRepositoryI;
use Filo\Menus\Domain\Service\MenuFinder as ServiceMenuFinder;

class MenuDeleterPhoto
{
    private ServiceMenuFinder $menuFinder;
    private MenuRepositoryI $repository;
    public function __construct(MenuRepositoryI $menuRepository)
    {
        $this->repository = $menuRepository;
        $this->menuFinder = new ServiceMenuFinder($menuRepository);
    }


    public function __invoke(MenuId $menuId)
    {
        $menu = $this->menuFinder->__invoke($menuId);
        $menu->deletePhoto();
        $this->repository->update($menu);
    }
}

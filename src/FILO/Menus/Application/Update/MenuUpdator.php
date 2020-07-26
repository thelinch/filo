<?php

namespace Filo\Menus\Application\Update;

use Filo\Menus\Domain\Menu;
use Filo\Menus\Domain\MenuDescription;
use Filo\Menus\Domain\MenuId;
use Filo\Menus\Domain\MenuName;
use Filo\Menus\Domain\MenuPhoto;
use Filo\Menus\Domain\MenuPrice;
use Filo\Menus\Domain\MenuRepositoryI;
use Filo\Menus\Domain\Service\MenuFinder as ServiceMenuFinder;

class MenuUpdator
{
    private ServiceMenuFinder $menuFinder;
    private MenuRepositoryI $repository;
    public function __construct(MenuRepositoryI $menuRepository)
    {
        $this->repository = $menuRepository;
        $this->menuFinder = new ServiceMenuFinder($menuRepository);
    }

    public function __invoke(MenuId $menuId, MenuName $newName, MenuDescription $newDescription, MenuPhoto $newPhoto, MenuPrice $newPrice)
    {
        $menu = $this->menuFinder->__invoke($menuId);
        $menu->update($newName->value(), $newPhoto->value(), $newPrice->value(), $newDescription->value());
        $this->repository->update($menu);
    }
}

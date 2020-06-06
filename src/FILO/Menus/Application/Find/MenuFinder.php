<?php

namespace Filo\Menus\Application\Find;

use Filo\Menus\Domain\Menu;
use Filo\Menus\Domain\MenuId;
use Filo\Menus\Domain\MenuRepositoryI;
use Filo\Menus\Domain\Service\MenuFinder as ServiceMenuFinder;

class MenuFinder
{
    private ServiceMenuFinder $menuFinder;

    public function __construct(MenuRepositoryI $menuRepository)
    {
        $this->menuFinder = new ServiceMenuFinder($menuRepository);
    }

    public function __invoke(MenuId $menuId): Menu
    {
        return $this->menuFinder->__invoke($menuId);
    }
}

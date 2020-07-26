<?php

namespace App\Http\Controllers\Menu;

use Filo\Menus\Application\Find\MenuDeleterPhoto;
use Filo\Menus\Application\Find\MenuFinder;
use Filo\Menus\Application\Find\MenuResponse;
use Filo\Menus\Application\Update\MenuUpdator;
use Filo\Menus\Domain\MenuDescription;
use Filo\Menus\Domain\MenuId;
use Filo\Menus\Domain\MenuName;
use Filo\Menus\Domain\MenuPhoto;
use Filo\Menus\Domain\MenuPrice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use src\Shared\Infraestructure\Eloquent\ApiController;

class MenuUpdateController extends ApiController

{
    private MenuUpdator $menuUpdator;
    public function __construct()
    {
        $this->menuUpdator = App::make(MenuUpdator::class);
    }
    public function exceptions(): array
    {
        return [];
    }

    public function __invoke(string $menuId, Request $request)
    {
        $menuParameter = $request->only(["name", "description", "price", "photo"]);
        $this->menuUpdator->__invoke(new MenuId($menuId), new MenuName($menuParameter["name"]), new MenuDescription($menuParameter["description"]), new MenuPhoto($menuParameter["photo"]), new MenuPrice($menuParameter["price"]));
    }
}

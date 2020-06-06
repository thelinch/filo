<?php

namespace App\Http\Controllers\Menu;

use Filo\Menus\Application\Update\MenuUpdate;
use Filo\Menus\Domain\MenuId;
use Filo\Menus\Domain\MenuName;
use Filo\Menus\Domain\MenuPrice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use src\Shared\Infraestructure\Eloquent\ApiController;

class MenuUpdateController extends ApiController
{
    private MenuUpdate $menuUpdate;
    public function __construct()
    {
        $this->menuUpdate = App::make("menuUpdate");
    }
    public function exceptions(): array
    {
        return [];
    }
    public function __invoke(Request $request)
    {
        $menuParameter = $request->only(["id", "name", "price"]);
        $this->menuUpdate->__invoke(new MenuId($menuParameter["id"]), new MenuName($menuParameter["name"]), new MenuPrice($menuParameter["price"]));
    }
}

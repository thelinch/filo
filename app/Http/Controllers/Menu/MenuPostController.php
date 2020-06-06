<?php

namespace App\Http\Controllers\Menu;

use Filo\Menus\Application\Create\MenuCreator;
use Filo\Menus\Domain\MenuId;
use Filo\Menus\Domain\MenuName;
use Filo\Menus\Domain\MenuPrice;
use Filo\Menus\Domain\MenuVotes;
use Filo\Partners\Domain\PartnerId;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use src\Shared\Infraestructure\Eloquent\ApiController;

class MenuPostController extends ApiController
{

    private MenuCreator $menuCreator;
    public function exceptions(): array
    {
        return [];
    }
    public function __construct()
    {
        $this->menuCreator = App::make("menuCreator");
    }
    public function __invoke(Request $request)
    {
        $menuParameter = $request->only(["id", "name", "price", "partnerId"]);
        $this->menuCreator->__invoke(
            new MenuId($menuParameter["id"]),
            new MenuName($menuParameter["name"]),
            new MenuPrice($menuParameter["price"]),
            new MenuVotes(0),
            new PartnerId($menuParameter["partnerId"])
        );
    }
}

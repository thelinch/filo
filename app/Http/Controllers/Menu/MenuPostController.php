<?php

namespace App\Http\Controllers\Menu;

use Filo\Menus\Application\Create\MenuCreator;
use Filo\Menus\Domain\MenuDescription;
use Filo\Menus\Domain\MenuId;
use Filo\Menus\Domain\MenuName;
use Filo\Menus\Domain\MenuPhoto;
use Filo\Menus\Domain\MenuPrice;
use Filo\Menus\Domain\MenuVotes;
use Filo\Partners\Domain\PartnerId;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
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
        $this->middleware("auth:api");
        $this->menuCreator = App::make("menuCreator");
    }
    public function __invoke(Request $request)
    {
        $menuParameter = $request->only(["id", "name", "price", "photo", "description"]);
        $partnerIdAuth = Auth::user()->partner->id;

        $this->menuCreator->__invoke(
            new MenuId($menuParameter["id"]),
            new MenuName($menuParameter["name"]),
            new MenuPrice($menuParameter["price"]),
            new MenuVotes(0),
            new PartnerId($partnerIdAuth),
            new MenuPhoto($menuParameter["photo"]),
            new MenuDescription($menuParameter["description"])
        );
    }
}

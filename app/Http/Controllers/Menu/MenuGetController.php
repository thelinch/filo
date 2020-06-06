<?php

namespace App\Http\Controllers\Menu;

use Filo\Menus\Application\Find\MenuFinder;
use Filo\Menus\Application\Find\MenuResponse;
use Filo\Menus\Domain\MenuId;
use Illuminate\Support\Facades\App;
use src\Shared\Infraestructure\Eloquent\ApiController;

class MenuGetController extends ApiController

{
    private MenuFinder $menuFinder;
    public function __construct()
    {
        $this->menuFinder = App::make("menuFinder");
    }
    public function exceptions(): array
    {
        return [];
    }

    public function __invoke(string $idMenu)
    {
        return new MenuResponse($this->menuFinder->__invoke(new MenuId($idMenu)));
    }
}

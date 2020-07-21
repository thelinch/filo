<?php

namespace App\Http\Controllers\Menu;

use Filo\Menus\Application\Find\MenuDeleterPhoto;
use Filo\Menus\Application\Find\MenuFinder;
use Filo\Menus\Application\Find\MenuResponse;
use Filo\Menus\Domain\MenuId;
use Illuminate\Support\Facades\App;
use src\Shared\Infraestructure\Eloquent\ApiController;

class MenuDeletePhotoController extends ApiController

{
    private MenuDeleterPhoto $menuDeleterPhoto;
    public function __construct()
    {
        $this->menuDeleterPhoto = App::make(MenuDeleterPhoto::class);
    }
    public function exceptions(): array
    {
        return [];
    }

    public function __invoke(string $idMenu)
    {
        $this->menuDeleterPhoto->__invoke(new MenuId($idMenu));
    }
}

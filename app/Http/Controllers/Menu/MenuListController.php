<?php

namespace App\Http\Controllers\Menu;

use Filo\Menus\Application\All\MenuListFindPartner;
use Filo\Menus\Application\All\MenuListResponse;
use Filo\Partners\Domain\PartnerId;
use Illuminate\Support\Facades\App;
use src\Shared\Domain\Pagination\NextPage;
use src\Shared\Domain\Pagination\NumberPerPage;
use src\Shared\Infraestructure\Eloquent\ApiController;

class MenuListController extends ApiController
{

    private MenuListFindPartner $menuListFindPartner;

    public function __construct()
    {
        $this->menuListFindPartner = App::make("menuListFindPartner");
    }
    public function exceptions(): array
    {
        return [];
    }
    public function __invoke(string $idPartner)
    {
        return new MenuListResponse($this->menuListFindPartner->__invoke(new NextPage(3), new NumberPerPage(4), new PartnerId($idPartner)));
    }
}

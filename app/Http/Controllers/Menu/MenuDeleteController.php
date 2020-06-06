<?php

namespace App\Http\Controllers\Menu;

use Filo\Menus\Application\Delete\MenuDelete;
use Filo\Menus\Domain\MenuId;
use Illuminate\Support\Facades\App;
use src\Shared\Infraestructure\Eloquent\ApiController;

class MenuDeleteController extends ApiController
{

    private MenuDelete $delete;
    public function __construct()
    {
        $this->delete = App::make("menuDelete");
    }
    public function exceptions(): array
    {
        return [];
    }

    public function __invoke(string $idMenu)
    {
        $this->delete->__invoke(new MenuId($idMenu));
    }
}

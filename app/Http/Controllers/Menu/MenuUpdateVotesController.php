<?php

namespace App\Http\Controllers\Menu;

use Filo\Menus\Application\IncrementVotes\VotesBooster;
use Filo\Menus\Domain\MenuId;
use Illuminate\Support\Facades\App;
use src\Shared\Infraestructure\Eloquent\ApiController;

class MenuUpdateVotesController extends ApiController

{
    private VotesBooster $votesBooster;
    public function __construct()
    {
        $this->votesBooster = App::make(VotesBooster::class);
    }
    public function exceptions(): array
    {
        return [];
    }

    public function __invoke(string $idMenu)
    {
        $this->votesBooster->__invoke(new MenuId($idMenu));
    }
}

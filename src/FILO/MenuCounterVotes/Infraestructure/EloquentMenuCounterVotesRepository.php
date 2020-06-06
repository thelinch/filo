<?php

namespace Filo\MenuCounterVotes\Infraestructure;

use Filo\MenuCounterVotes\Domain\MenuCounterVotes;
use Filo\MenuCounterVotes\Domain\MenuCounterVotesRepository;
use Filo\Menus\Infraestructure\MenuModel;

class EloquentMenuCounterVotesRepository implements MenuCounterVotesRepository
{
    function updateVotes(MenuCounterVotes $menuCounterVotes)
    {
        $menuModel = MenuModel::find($menuCounterVotes->menuId()->value());
        $menuModel->votes = $menuCounterVotes->total()->value();
        $menuModel->save();
    }
}

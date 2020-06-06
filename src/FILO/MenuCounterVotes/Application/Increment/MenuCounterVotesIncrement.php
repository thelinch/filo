<?php

namespace Filo\MenuCounterVotes\Application\Increment;

use Filo\MenuCounterVotes\Domain\MenuCounterVotes;
use Filo\MenuCounterVotes\Domain\MenuCounterVotesRepository;
use Filo\MenuCounterVotes\Domain\MenuCounterVotesTotal;
use Filo\Menus\Domain\MenuId;
use Filo\Menus\Domain\Service\MenuFinder;
use Illuminate\Support\Facades\App;
use src\Shared\Domain\Bus\Command\Command;

class MenuCounterVotesIncrement implements Command
{
    private MenuFinder $menuFinder;
    private MenuCounterVotesRepository $repository;

    public function __construct(MenuCounterVotesRepository $repository)
    {
        $this->repository = $repository;
        $this->menuFinder = App::make("menuFinder");
    }

    public function __invoke(MenuId $menuId): void
    {
        $menu = $this->menuFinder->__invoke($menuId);
        $counter = new MenuCounterVotes($menuId, new MenuCounterVotesTotal($menu->votes()->value()));
        $counter->increment();
        $this->repository->updateVotes($counter);
    }
}

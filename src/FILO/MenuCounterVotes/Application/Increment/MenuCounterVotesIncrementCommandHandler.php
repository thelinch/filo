<?php

namespace Filo\MenuCounterVotes\Application\Increment;

use Filo\Menus\Domain\MenuId;
use Illuminate\Support\Facades\App;
use src\Shared\Domain\Bus\Command\CommandHandler;

class MenuCounterVotesIncrementCommandHandler implements CommandHandler
{

    private MenuCounterVotesIncrement $menuCounterVotesIncrement;
    public function __construct()
    {
        $this->menuCounterVotesIncrement = App::make("menuCounterVotesIncrement");
    }
    public function handle(\Rosamarsky\CommandBus\Command $command)
    {
        $id = new MenuId($command->id());
        $this->menuCounterVotesIncrement->__invoke($id);
    }
}

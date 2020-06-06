<?php

namespace Filo\MenuCounterVotes\Application\Decrement;

use Filo\Menus\Domain\MenuId;
use Illuminate\Support\Facades\App;
use src\Shared\Domain\Bus\Command\CommandHandler;

class MenuCounterVotesDecrementCommandHandler implements CommandHandler
{

    private MenuCounterVotesDecrement $menuCounterVotesDecrement;
    public function __construct()
    {
        $this->menuCounterVotesDecrement = App::make("menuCounterVotesDecrement");
    }
    public function handle(\Rosamarsky\CommandBus\Command $command)
    {
        $id = new MenuId($command->id());
        $this->menuCounterVotesDecrement->__invoke($id);
    }
}

<?php

namespace Filo\MenuCounterVotes\Application\Increment;

use src\Shared\Domain\Bus\Command\Command;

class MenuCounterVotesIncrementCommand implements Command
{
    private string $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }
    public function id(): string
    {
        return $this->id;
    }
}

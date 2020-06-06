<?php

namespace Filo\MenuCounterVotes\Application\Decrement;

use src\Shared\Domain\Bus\Command\Command;

class MenuCounterVotesDecrementCommand implements Command
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

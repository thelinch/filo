<?php

namespace src\Shared\Infraestructure\Bus\Command;

use src\Shared\Domain\Bus\Command\CommandBus;

final class RosamarskyCommandBus implements CommandBus
{
    private \Rosamarsky\CommandBus\CommandBus $bus;


    public function __construct(\Rosamarsky\CommandBus\CommandBus $dispacher)
    {
        $this->bus = $dispacher;
    }
    public function dispatch(\Rosamarsky\CommandBus\Command $command): void
    {
        $this->bus->execute($command);
    }
}

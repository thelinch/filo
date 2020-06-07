<?php

namespace src\Shared\Infraestructure\Eloquent;

use src\Shared\Domain\Bus\Event\EventBus;

/* use src\Shared\Domain\Bus\Command\Command;
use src\Shared\Domain\Bus\Command\CommandBus;
use src\Shared\Domain\Bus\Query\Query;
use src\Shared\Domain\Bus\Query\QueryBus;
use src\Shared\Domain\Bus\Query\Response; */

abstract class ApiController extends \Illuminate\Routing\Controller
{
    /*    private CommandBus $commandBus;
    private QueryBus $queryBus;
    public function __construct(CommandBus $commandBus, QueryBus $queryBus)
    {
        $this->commandBus = $commandBus;
        $this->queryBus = $queryBus;
    }

    //protected function dispatch(\Rosamarsky\CommandBus\Command $command)
    protected function dispatch(Command $command)
    {
        $this->commandBus->dispatch($command);
    }
    protected function ask(Query $query): ?Response
    {
        return $this->queryBus->ask($query);
    } */
    abstract protected function exceptions(): array;
    private function exceptionRegister(): callable
    {
        return function ($httpCode, $exception): void {
        };
    }
}

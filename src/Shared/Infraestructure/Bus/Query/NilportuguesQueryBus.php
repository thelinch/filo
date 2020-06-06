<?php

namespace src\Shared\Infraestructure\Bus\Query;

use NilPortugues\MessageBus\QueryBus\Contracts\Query;
use NilPortugues\MessageBus\QueryBus\Contracts\QueryResponse;
use NilPortugues\MessageBus\QueryBus\QueryBus as QueryBusQueryBus;
use src\Shared\Domain\Bus\Query\QueryBus;

class NilportuguesQueryBus implements QueryBus
{

    private  QueryBusQueryBus $queryBus;

    public function __construct(QueryBusQueryBus $queryBus)
    {
        $this->queryBus = $queryBus;
    }
    public function ask(Query $query): ?QueryResponse
    {
        //        dd($query);
        $queryBus = $this->queryBus;
        return $queryBus($query);
    }
}

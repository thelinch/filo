<?php

namespace src\Shared\Domain\Bus\Query;


interface QueryBus
{
    function ask(Query $query): ?Response;
}

<?php

namespace Filo\Transactions\Infraestructure\ConcretState;

use Filo\Transactions\Infraestructure\State\TransactionState;


class OnMyWay extends TransactionState
{
    public function name(): string
    {
        return "En Camino";
    }
}

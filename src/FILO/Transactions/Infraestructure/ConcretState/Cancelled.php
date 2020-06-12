<?php

namespace Filo\Transactions\Infraestructure\ConcretState;

use Filo\Transactions\Infraestructure\State\TransactionState;

class Cancelled extends TransactionState
{
    public function name(): string
    {
        return "Cancelado";
    }
}

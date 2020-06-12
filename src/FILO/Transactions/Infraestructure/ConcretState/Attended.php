<?php

namespace Filo\Transactions\Infraestructure\ConcretState;

use Filo\Transactions\Infraestructure\State\TransactionState;

class Attended extends TransactionState
{
    public function name(): string
    {
        return "Atendido";
    }
}

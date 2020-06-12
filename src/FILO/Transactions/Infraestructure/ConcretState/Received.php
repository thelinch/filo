<?php

namespace Filo\Transactions\Infraestructure\ConcretState;

use Filo\Transactions\Infraestructure\State\TransactionState;

class Received extends TransactionState
{
    public function name(): string
    {
        return "Recibido";
    }
}
